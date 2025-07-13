<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sedang_proses;
use App\Models\status_proses;
use Illuminate\Support\Facades\DB;

class statusprosesController extends Controller
{
    // Menampilkan form tambah status
    public function formTambah($id)
    {
        $sedangProses = Sedang_proses::findOrFail($id);
        return view('page.Penyedia_layanan.status_proses', compact('sedangProses'));
    }

    // Menyimpan data status baru
    public function simpan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:30',
        ]);

        DB::beginTransaction();

        try {
            status_proses::create([
                'id_sedang_proses' => $id,
                'status' => $request->status,
                'waktu' => now(),
            ]);

            DB::commit();

            return redirect()->route('penyedia.pesanan.detail', ['id' => Sedang_proses::find($id)->id_pesanan])
                             ->with('success', 'Status berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan status: ' . $e->getMessage());
        }
    }
}
