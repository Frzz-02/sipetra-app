<?php

namespace App\Http\Controllers;

use App\Models\layanan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hewan;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
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
         $pesanans = Pesanan::with(['details.layanan'])
        ->where('id_user', auth::user()->id)
        ->orderByDesc('id') // urut dari ID tertinggi (pesanan terbaru)
        ->get();

        return view('page.User.riwayat', compact('pesanans'));
    }
    public function riwayat_detail($id)
    {
         $pesanan = Pesanan::with([
            'details.hewan', // Ambil data hewan
            'details.layanan',
            'details.layanan_detail', // Ambil layanan dari detail
            'penyediaLayanan', // jika ingin info toko
        ])->findOrFail($id);

        $layanan = optional($pesanan->details->first())->layanan_detail;
        $tipe = strtolower(optional($pesanan->details->first()?->layanan_detail?->layanan)->tipe_input ?? 'lainnya');
        $hargaPerItem = optional($layanan)->harga_dasar ?? 0;
        $biayaPotongan = $pesanan->total_biaya * 0.1;
        $biayaTotal = $pesanan->total_biaya + $biayaPotongan;
        $jumlahHewan = $pesanan->details->count();
        $lokasiKandang = $pesanan->lokasi_kandang ?? null;
        //penitipan hewan
        $tanggal_titip = $pesanan->tanggal_titip ?? null;
        $tanggal_ambil = $pesanan->tanggal_ambil ?? null;
        $jumlah_hari = $pesanan->jumlah_hari ?? null;
        //antar jemput
        $alamatAwal = $this->getAddressFromCoordinates($pesanan->lokasi_awal);
        $alamatTujuan = $this->getAddressFromCoordinates($pesanan->lokasi_tujuan);
        $total_jarak = $pesanan->total_jarak ?? null;
        //pembersihan kandang
        $jumlahKandang =$pesanan->jumlah_kandang ?? null;
        $luasKandang = $pesanan->luas_kandang ?? null;
        $lokasiKandang = $pesanan->lokasi_kandang ?? null;
        //lainnya
        $tanggal_mulai = $pesanan->tanggal_mulai ?? null;


        return view('page.User.riwayat_detail', compact(
            'pesanan',
            'biayaPotongan',
            'biayaTotal',
            'alamatAwal',
            'alamatTujuan',
            'total_jarak',
            'layanan',
            'hargaPerItem',
            'tipe',
            'jumlahHewan',
            'jumlahKandang',
            'luasKandang',
            'jumlah_hari',
            'lokasiKandang',
            'tanggal_titip',
            'tanggal_ambil',
            'tanggal_mulai'
        ));

    }
    public function detailProsesPesanan($id_pesanan)
    {
        $sedangProses = \App\Models\Sedang_proses::with([
            'petugas.karyawan',
            'status_proses',
            'pesanan'
        ])->where('id_pesanan', $id_pesanan)->first();

        if (!$sedangProses) {
            return back()->with('error', 'Data proses tidak ditemukan.');
        }

        return view('page.User.detail_proses', compact('sedangProses'));
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

}





