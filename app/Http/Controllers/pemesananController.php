<?php

namespace App\Http\Controllers;

use App\Models\{Hewan, Layanan, Penyedia_layanan_detail, Pesanan, Pesanan_detail};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Http};
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class PemesananController extends Controller
{
    /**
     * Menampilkan form pemesanan.
     */
    public function create($id_layanan)
    {
        $userId = Auth::user()->id;
        $hewans = Hewan::where('id_user', $userId)->get();
        $layanan = Layanan::findOrFail($id_layanan);

        $layananDetails = Penyedia_layanan_detail::with('layanan')
            ->where('id_layanan', $id_layanan)
            ->get();

        return view('page.User.pemesanan', compact('hewans', 'layananDetails', 'layanan'));
    }

    /**
     * Menyimpan pesanan dan arahkan ke pembayaran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_hewan' => 'required|array|min:1',
            'id_hewan.*' => 'exists:hewans,id',
            'id_variasi' => 'required|exists:penyedia_layanan_details,id',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user()->id;

            $variasi = Penyedia_layanan_detail::findOrFail($request->id_variasi);
            $layanan = $variasi->layanan;
            $harga = $variasi->harga_dasar;
            $opsi = $variasi->opsi ?? json_encode([]);

            $jumlahHewan = count($request->id_hewan);
            $tipe = strtolower($layanan->tipe_input);
            $totalBiaya = 0;

            if ($tipe === 'penitipan') {
                $tanggalTitip = Carbon::parse($request->tanggal_titip);
                $tanggalAmbil = Carbon::parse($request->tanggal_ambil);
                $jumlahHari = $tanggalTitip->diffInDays($tanggalAmbil) ?: 1;
                $totalBiaya = $jumlahHari * $jumlahHewan * $harga;

            } elseif ($tipe === 'antar jemput') {
                  if (!$request->lokasi_awal || !$request->lokasi_tujuan) {
                        throw new \Exception("Lokasi awal dan tujuan harus diisi.");
                    }
                $jarakKm = $this->hitungJarakKm($request->lokasi_awal, $request->lokasi_tujuan);
                $totalBiaya = $jarakKm * $harga * $jumlahHewan;

            } else {
                $totalBiaya = $jumlahHewan * $harga;
            }

            $pesanan = Pesanan::create([
                'id_user' => $user,
                'id_penyedia_layanan' => $variasi->id_penyedia,
                'tanggal_pesan' => $request->tanggal_pesan ?? now(),
                'tanggal_titip' => $request->tanggal_titip ?? null,
                'tanggal_ambil' => $request->tanggal_ambil ?? null,
                'tanggal_mulai' => $request->tanggal_titip ?? null,
                'tanggal_selesai' => $request->tanggal_ambil ?? null,
                'lokasi_awal' => $request->lokasi_awal ?? null,
                'lokasi_tujuan' => $request->lokasi_tujuan ?? null,
                'total_biaya' => $totalBiaya,
                'status' => 'menunggu'
            ]);

            foreach ($request->id_hewan as $idHewan) {
                Pesanan_detail::create([
                    'id_pesanan' => $pesanan->id,
                    'id_hewan' => $idHewan,
                    'id_layanan' => $variasi->id_layanan,
                    'data_opsi_layanan' => $opsi,
                    'subtotal_biaya' => $harga,
                ]);
            }

            DB::commit();

            return redirect()->route('pembayaran.lanjutkan', ['id_pesanan' => $pesanan->id])
                ->with('success', 'Pesanan berhasil dibuat, lanjutkan ke pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();

            dd([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }

    }

protected function hitungJarakKm($lokasiAwal, $lokasiTujuan)
{
    $apiKey = env('ORS_API_KEY');

    // Deteksi apakah input sudah dalam format koordinat
    if (str_contains($lokasiAwal, ',') && str_contains($lokasiTujuan, ',')) {
        $awal = explode(',', $lokasiAwal);
        $tujuan = explode(',', $lokasiTujuan);

        // Format untuk ORS: [long, lat]
        $coordAwal = [floatval($awal[1]), floatval($awal[0])];
        $coordTujuan = [floatval($tujuan[1]), floatval($tujuan[0])];
    } else {
        // Jika bukan koordinat, gunakan Geocode API
        $geocodeUrl = 'https://api.openrouteservice.org/geocode/search';

        $responseAwal = Http::withHeaders([
            'Authorization' => $apiKey
        ])->get($geocodeUrl, ['text' => $lokasiAwal]);

        $responseTujuan = Http::withHeaders([
            'Authorization' => $apiKey
        ])->get($geocodeUrl, ['text' => $lokasiTujuan]);

        $dataAwal = $responseAwal->json();
        $dataTujuan = $responseTujuan->json();

        if (
            !isset($dataAwal['features'][0]['geometry']['coordinates']) ||
            !isset($dataTujuan['features'][0]['geometry']['coordinates'])
        ) {
            throw new \Exception("Koordinat tidak ditemukan.");
        }

        $coordAwal = $dataAwal['features'][0]['geometry']['coordinates'];
        $coordTujuan = $dataTujuan['features'][0]['geometry']['coordinates'];
    }

    // Hitung jarak via ORS Directions API
    $responseJarak = Http::withHeaders([
        'Authorization' => $apiKey,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->post('https://api.openrouteservice.org/v2/directions/driving-car', [
        'coordinates' => [$coordAwal, $coordTujuan]
    ]);

    if ($responseJarak->failed()) {
        throw new \Exception("Gagal menghitung jarak dengan ORS.");
    }

    $data = $responseJarak->json();

    if (!isset($data['routes'][0]['segments'][0]['distance'])) {
        throw new \Exception("Data jarak tidak tersedia.");
    }

    $jarakMeter = $data['routes'][0]['segments'][0]['distance'];


    return round($jarakMeter / 1000, 2); // hasil KM
}


}
