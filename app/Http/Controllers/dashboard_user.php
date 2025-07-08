<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hewan;
use App\Models\Pesanan;
use GuzzleHttp\Client;

class dashboard_user extends Controller
{
    public function index()
    {
        return view('page.User.dashboard_users');
    }
    public function showhewan()
    {
        $user = Auth::user(); // user yang login

        $hewan = Hewan::where('id_user', $user->id)->get();

       return view('page.User.dashboard_users', compact('hewan'));
    }
    public function riwayat()
    {
         $pesanans = \App\Models\Pesanan::with(['details.layanan'])
        ->where('id_user', auth::user()->id)
        ->orderByDesc('id') // urut dari ID tertinggi (pesanan terbaru)
        ->get();

        return view('page.User.riwayat', compact('pesanans'));
    }
    public function riwayat_detail($id)
    {
        $pesanan = Pesanan::with(['details.layanan', 'details.hewan', 'penyediaLayanan'])
            ->where('id', $id)
            ->where('id_user', auth::user()->id)
            ->firstOrFail();

        $biayaPotongan = $pesanan->total_biaya * 0.1;
        $biayaTotal = $pesanan->total_biaya + $biayaPotongan;

        $alamatAwal = $this->getAddressFromCoordinates($pesanan->lokasi_awal);
        $alamatTujuan = $this->getAddressFromCoordinates($pesanan->lokasi_tujuan);

        $jarakKm = null;
        if ($pesanan->lokasi_awal && $pesanan->lokasi_tujuan) {
            $jarakKm = $this->calculateDistance($pesanan->lokasi_awal, $pesanan->lokasi_tujuan);
        }

        // Tambahan: persiapan data layanan
        $detailPertama = $pesanan->details->first();
        $layanan = optional($detailPertama)->layanan;
        $hargaPerItem = optional($detailPertama)->subtotal_biaya;
        $tipe = strtolower($layanan->tipe_input ?? 'lainnya');

        $jumlahKandang =$pesanan->jumlah_kandang ?? null;
        $luasKandang = $pesanan->luas_kandang ?? null;

        $jumlahHewan = $pesanan->details->count();
        $jumlahHari = null;
        if ($tipe === 'penitipan' && $pesanan->tanggal_titip && $pesanan->tanggal_ambil) {
            $jumlahHari = \Carbon\Carbon::parse($pesanan->tanggal_titip)
                ->diffInDays(\Carbon\Carbon::parse($pesanan->tanggal_ambil)) ?: 1;
        }

        return view('page.User.riwayat_detail', compact(
            'pesanan',
            'biayaPotongan',
            'biayaTotal',
            'alamatAwal',
            'alamatTujuan',
            'jarakKm',
            'layanan',
            'hargaPerItem',
            'tipe',
            'jumlahHewan',
            'jumlahHari',
            'jumlahKandang',
            'luasKandang'
        ));
    }


    private function getAddressFromCoordinates($coordinates)
    {
        if (!$coordinates || !str_contains($coordinates, ',')) {
            return 'Koordinat tidak valid';
        }

        [$lat, $lon] = explode(',', $coordinates);

        if (!is_numeric($lat) || !is_numeric($lon)) {
            return 'Koordinat tidak valid';
        }

        try {
            $client = new Client();
            $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                    'format' => 'json'
                ],
                'headers' => [
                    'User-Agent' => 'SipetraApp/1.0'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['display_name'] ?? 'Alamat tidak ditemukan';
        } catch (\Exception $e) {
            return 'Alamat tidak ditemukan';
        }
    }


    private function calculateDistance($coord1, $coord2)
    {
        if (!str_contains($coord1, ',') || !str_contains($coord2, ',')) {
            return 0; // atau null, tergantung kebutuhan
        }

        [$lat1, $lon1] = explode(',', $coord1);
        [$lat2, $lon2] = explode(',', $coord2);

        if (!is_numeric($lat1) || !is_numeric($lon1) || !is_numeric($lat2) || !is_numeric($lon2)) {
            return 0;
        }

        // selanjutnya tetap seperti sebelumnya...
        $earthRadius = 6371;

        $lat1 = deg2rad((float)$lat1);
        $lon1 = deg2rad((float)$lon1);
        $lat2 = deg2rad((float)$lat2);
        $lon2 = deg2rad((float)$lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return round($earthRadius * $c, 2);
    }


}





