<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\Layanan;
use App\Models\Penyedia_layanan_detail;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PemesananController extends Controller
{
    /**
     * Menampilkan form pemesanan.
     */
    public function create($id_layanan)
    {
        $userId = auth::user()->id;

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
            $user = auth::user()->id;

            $variasi = Penyedia_layanan_detail::findOrFail($request->id_variasi);
            $layanan = $variasi->layanan;
            $harga = $variasi->harga_dasar;
            $opsi = $variasi->opsi ?? json_encode([]);

            $jumlahHewan = count($request->id_hewan);
            $totalBiaya = $harga * $jumlahHewan;


            $pesanan = Pesanan::create([
                'id_user' => $user,
                'id_penyedia_layanan' => $variasi->id_penyedia ,
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
            dd($e->getMessage()); // sementara tampilkan pesan error
        }
    }
}
