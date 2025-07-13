<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Penyedia_layanan;
use App\Models\foto_penyedia;

class DashboardPenyediaController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ID dari user yang login

        // Ambil ID penyedia_layanan berdasarkan id_user
        $penyediaId = Penyedia_layanan::where('id_user', $userId)->value('id');

        // Data jumlah layanan (berdasarkan id_user)
        $jumlah_layanan = Layanan::where('id_user', $userId)->count();

        // Data pesanan berdasarkan id_penyedia_layanan
        $jumlah_pesanan = Pesanan::where('id_penyedia_layanan', $penyediaId)
        ->whereNotIn('status', ['menunggu pembayaran', 'batal'])
        ->count();


        // Total pendapatan dari pesanan yang selesai
        $total_pendapatan = Pesanan::where('id_penyedia_layanan', $penyediaId)
            ->where('status', 'selesai')
            ->sum('total_biaya');

        // Ambil 5 pesanan terbaru (kecuali status tertentu)
        $pesanan_terbaru = Pesanan::with('user')
            ->where('id_penyedia_layanan', $penyediaId)
            ->whereNotIn('status', ['menunggu pembayaran', 'batal'])
            ->orderByDesc('id')
            ->take(10)
            ->get();

        return view('page.Penyedia_layanan.dashboard_penyedia_jasa', compact(
            'jumlah_layanan',
            'jumlah_pesanan',
            'total_pendapatan',
            'pesanan_terbaru'
        ));
    }
    public function tampilantoko()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        // Ambil data penyedia beserta layanan dan foto-foto tambahan
        $penyedia = \App\Models\Penyedia_layanan::with(['layanans', 'fotos'])
            ->where('id_user', $userId)
            ->firstOrFail();

        return view('page.Penyedia_layanan.tampilan_toko', compact('penyedia'));
    }


    public function updateField(Request $request, $id)
    {
        $penyedia = Penyedia_layanan::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        // Daftar field yang diizinkan untuk inline edit
        $allowedFields = ['nama_toko', 'alamat_toko', 'deskripsi'];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Field tidak valid'], 400);
        }

        $penyedia->$field = $value;
        $penyedia->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }
    public function inlineUpdate(Request $request, $id)
    {
        $penyedia = Penyedia_layanan::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        if (!in_array($field, ['nama_toko', 'alamat_toko', 'deskripsi', 'color_heading', 'color_font', 'color_font_judul', 'color_button'])) {
            return response()->json(['success' => false, 'message' => 'Field tidak diizinkan'], 400);
        }

        $penyedia->$field = $value;
        $penyedia->save();

        return response()->json(['success' => true]);
    }

    public function uploadFoto(Request $request, $id)
    {
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke folder public/assets/hewan
            $file->move(public_path('assets/foto_penyedia'), $filename);

            // Path yang disimpan relatif terhadap public/
            $relativePath = 'assets/foto_penyedia/' . $filename;

            // Simpan ke database
            Foto_penyedia::create([
                'id_penyedia_layanan' => $id,
                'foto' => $relativePath,
            ]);

            return response()->json(['success' => true, 'path' => $relativePath]);
        }

        return response()->json(['success' => false, 'message' => 'File tidak ditemukan']);
    }
    public function hapusFoto($id)
    {
        $foto = Foto_penyedia::findOrFail($id);

        // Hapus file dari sistem
        if (file_exists(public_path($foto->foto))) {
            unlink(public_path($foto->foto));
        }

        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
    public function ulasan()
    {
       $userId = Auth::id(); // Ambil ID user yang sedang login

        // Ambil data penyedia beserta layanan, foto-foto tambahan, dan ulasan
        $penyedia = \App\Models\Penyedia_layanan::with([
            'layanans',
            'fotos',
            'ulasan.user' // ulasan beserta user-nya
        ])
        ->where('id_user', $userId)
        ->firstOrFail();
        return view('page.Penyedia_layanan.ulasan', compact('penyedia'));
    }


}
