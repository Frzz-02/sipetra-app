<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Pesanan;
use Carbon\Carbon;
use Polyline\Polyline;

class detailPesanan_penyediaJasa extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'details.layanan', 'details.hewan'])->findOrFail($id);

        $user = $pesanan->user;
        $layanan = optional($pesanan->details->first())->layanan;
        $tipe = strtolower($layanan->tipe_input ?? 'lainnya');

        $jumlahHewan = $pesanan->details->count();
        $hargaPerItem = optional($pesanan->details->first())->subtotal_biaya;

        $opsi = json_decode(optional($pesanan->details->first())->data_opsi_layanan, true);
        $jumlahKandang = $opsi['jumlah_kandang'] ?? null;
        $luasKandang = $opsi['luas_kandang'] ?? null;

        $jumlahHari = null;
        if ($tipe === 'penitipan' && $pesanan->tanggal_titip && $pesanan->tanggal_ambil) {
            $jumlahHari = Carbon::parse($pesanan->tanggal_titip)->diffInDays(Carbon::parse($pesanan->tanggal_ambil)) ?: 1;
        }

        $biayaPotongan = $pesanan->total_biaya * 0.1;
        $biayaTotal = $pesanan->total_biaya + $biayaPotongan;

        // Format tanggal
        $pesanan->formatted_tanggal_pesan = Carbon::parse($pesanan->tanggal_pesan)->format('d-m-Y H:i');
        $pesanan->formatted_tanggal_titip = $pesanan->tanggal_titip ? Carbon::parse($pesanan->tanggal_titip)->format('d-m-Y') : null;
        $pesanan->formatted_tanggal_ambil = $pesanan->tanggal_ambil ? Carbon::parse($pesanan->tanggal_ambil)->format('d-m-Y') : null;
        $pesanan->formatted_tanggal_mulai = $pesanan->tanggal_mulai ? Carbon::parse($pesanan->tanggal_mulai)->format('d-m-Y') : null;

        $badgeColor = match ($pesanan->status) {
            'menunggu pembayaran' => 'secondary',
            'menunggu diproses' => 'warning text-dark',
            'diproses' => 'info',
            'selesai' => 'success',
            'batal' => 'danger',
            default => 'light text-dark'
        };

        $alamatAwal = $this->getAddressFromCoordinates($pesanan->lokasi_awal);
        $alamatTujuan = $this->getAddressFromCoordinates($pesanan->lokasi_tujuan);

        $lokasiAwal = $this->parseCoordinates($pesanan->lokasi_awal);
        $lokasiTujuan = $this->parseCoordinates($pesanan->lokasi_tujuan);

        $jarakKm = null;
        $ruteGeoJson = null;
        if ($lokasiAwal && $lokasiTujuan) {
            $jarakKm = $this->calculateDistance($lokasiAwal, $lokasiTujuan);
            $ruteGeoJson = $this->getRouteGeoJson($lokasiAwal, $lokasiTujuan);
        }

        return view('page.Penyedia_layanan.detail_pesanan', compact(
            'pesanan', 'user', 'tipe', 'jumlahHewan', 'hargaPerItem',
            'jumlahHari', 'jumlahKandang', 'luasKandang', 'biayaPotongan',
            'biayaTotal', 'badgeColor', 'alamatAwal', 'alamatTujuan',
            'lokasiAwal', 'lokasiTujuan', 'jarakKm', 'ruteGeoJson'
        ));
    }

    private function getAddressFromCoordinates($coordinates)
    {
        if (!$coordinates || !str_contains($coordinates, ',')) return 'Alamat tidak tersedia';

        [$lat, $lon] = explode(',', $coordinates);

        $apiKey = env('ORS_API_KEY');
        $response = Http::get("https://api.openrouteservice.org/geocode/reverse", [
            'api_key' => $apiKey,
            'point.lat' => $lat,
            'point.lon' => $lon,
            'size' => 1,
        ]);

        if ($response->successful()) {
            return $response['features'][0]['properties']['label'] ?? 'Alamat tidak ditemukan';
        }

        return 'Alamat tidak tersedia';
    }

    private function parseCoordinates($value)
    {
        if (!$value || !str_contains($value, ',')) return null;
        [$lat, $lon] = explode(',', $value);
        return ['lat' => (float) $lat, 'lon' => (float) $lon];
    }

    private function calculateDistance($start, $end)
    {
        $apiKey = env('ORS_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
            'Accept' => 'application/json',
        ])->post('https://api.openrouteservice.org/v2/directions/driving-car', [
            'coordinates' => [
                [(float)$start['lon'], (float)$start['lat']],
                [(float)$end['lon'], (float)$end['lat']]
            ]
        ]);

        if ($response->successful()) {
            $meters = $response['routes'][0]['summary']['distance'] ?? 0;
            return round($meters / 1000, 1); // KM
        }

        return null;
    }


private function getRouteGeoJson($start, $end)
{
    $apiKey = env('ORS_API_KEY');

    $coordinates = [
        [(float) $start['lon'], (float) $start['lat']],
        [(float) $end['lon'], (float) $end['lat']],
    ];

    $response = Http::withHeaders([
        'Authorization' => $apiKey,
        'Accept' => 'application/json',
    ])->post('https://api.openrouteservice.org/v2/directions/driving-car', [
        'coordinates' => $coordinates
    ]);

    if (!$response->successful()) {
        dd([
            'status_code' => $response->status(),
            'reason' => 'Request failed',
            'coordinates_sent' => $coordinates,
            'response_body' => $response->body(),
        ]);
    }

    $encoded = $response['routes'][0]['geometry'] ?? null;

    if (!$encoded) {
        dd([
            'status_code' => $response->status(),
            'reason' => 'Geometry (encoded) kosong',
            'response_body' => $response->json(),
        ]);
    }

    $decodedCoords = $this->decodePolyline($encoded);

    // Konversi ke format [lon, lat] sesuai GeoJSON
    $geoJsonCoordinates = array_map(function ($coord) {
        return [$coord[1], $coord[0]];
    }, $decodedCoords);

    return [
        'type' => 'FeatureCollection',
        'features' => [[
            'type' => 'Feature',
            'geometry' => [
                'type' => 'LineString',
                'coordinates' => $geoJsonCoordinates
            ],
            'properties' => new \stdClass()
        ]]
    ];
}

private function decodePolyline($encoded)
{
    $points = [];
    $index = $lat = $lng = 0;

    while ($index < strlen($encoded)) {
        $result = 1;
        $shift = 0;
        do {
            $b = ord($encoded[$index++]) - 63 - 1;
            $result += $b << $shift;
            $shift += 5;
        } while ($b >= 0x1f);
        $lat += ($result & 1) ? ~($result >> 1) : ($result >> 1);

        $result = 1;
        $shift = 0;
        do {
            $b = ord($encoded[$index++]) - 63 - 1;
            $result += $b << $shift;
            $shift += 5;
        } while ($b >= 0x1f);
        $lng += ($result & 1) ? ~($result >> 1) : ($result >> 1);

        $points[] = [$lat * 1e-5, $lng * 1e-5];
    }

    return $points;
}


}
