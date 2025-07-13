<?php

namespace App\Http\Controllers;

use App\Models\layanan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hewan;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;



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
        $sedangProses = \App\Models\Sedang_proses::with([
            'petugas.karyawan',
            'status_proses',
            'pesanan'
        ])->where('id_pesanan', $id)->first();


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
        $statusProsesTerakhir = '-';

        if ($sedangProses && $sedangProses->status_proses->isNotEmpty()) {
            $statusProsesTerakhir = $sedangProses->status_proses->last()->status;
        }




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
            'tanggal_mulai',
            'sedangProses',
            'statusProsesTerakhir'
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
    public function batalPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if (in_array($pesanan->status, ['menunggu pembayaran', 'menunggu diproses'])) {
            $pesanan->status = 'batal';
            $pesanan->save();

            return redirect()->route('riwayat.pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
   public function updateFotoProfil(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists('foto_profil/' . $user->foto_profil)) {
            Storage::disk('public')->delete('foto_profil/' . $user->foto_profil);
        }

        // Simpan foto baru
        $filename = uniqid() . '.' . $request->file('foto_profil')->getClientOriginalExtension();
        $request->file('foto_profil')->storeAs('foto_profil', $filename, 'public');
        /** @var \App\Models\User $user */
        // Update nama file ke database
        $user->foto_profil = $filename;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|in:username,email,no_telephone,alamat',
            'value' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $field = $request->input('field');
        $value = $request->input('value');
        /** @var \App\Models\User $user */
        $user->$field = $value;
        $user->save();

        return response()->json([
            'success' => true,
            'new_value' => $value
        ]);
    }

}





