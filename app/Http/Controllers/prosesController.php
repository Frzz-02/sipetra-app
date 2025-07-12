<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Sedang_proses;
use App\Models\petugas_yang_menangani;
use App\Models\status_proses;
use App\Models\Karyawan;
use App\Models\Penyedia_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class prosesController extends Controller
{
    public function prosesPesanan(Request $request, $id)
    {

        DB::beginTransaction();

        try {
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->status = 'diproses';
            $pesanan->save();

            $sedangProses = Sedang_proses::create([
                'id_pesanan' => $pesanan->id,
                'catatan' => null,
            ]);

            DB::commit();

            return redirect()->route('penugasan.form', ['id' => $sedangProses->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function formPenugasan($id)
    {
        $sedangProses = Sedang_proses::with('pesanan')->findOrFail($id);
        $idPenyedia = Penyedia_layanan::where('id_user', Auth::id())->value('id');
        $karyawans = Karyawan::where('id_penyedia_layanan', $idPenyedia)->get();

        return view('page.Penyedia_layanan.proses', compact('sedangProses', 'karyawans'));
    }

    public function simpanPenugasan(Request $request, $id)
    {
        $request->validate([
            'karyawan_ids' => 'required|array',
            'karyawan_ids.*' => 'exists:karyawans,id',
            'catatan' => 'nullable|string|max:255',
            'status' => 'required|string|max:30',
        ]);

        DB::beginTransaction();

        try {
            $sedangProses = Sedang_proses::findOrFail($id);
            $sedangProses->catatan = $request->catatan;
            $sedangProses->save();

            foreach ($request->karyawan_ids as $idKaryawan) {
                petugas_yang_menangani::create([
                    'id_sedang_proses' => $sedangProses->id,
                    'id_karyawan' => $idKaryawan,
                ]);
            }

            status_proses::create([
                'id_sedang_proses' => $sedangProses->id,
                'status' => $request->status,
                'waktu' => now(),
            ]);

            DB::commit();

           return redirect()->route('penyedia.pesanan.detail', ['id' => $sedangProses->id_pesanan])
         ->with('success', 'Penugasan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan penugasan: ' . $e->getMessage());
        }
    }
    public function selesaikanPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->save();

        return back()->with('success', 'Pesanan telah diselesaikan.');
    }

}
