<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function lanjut($id_layanan)
    {
        $layanan = Layanan::findOrFail($id_layanan);
        $pesanan = Pesanan::where('id_user', auth::user()->id)
            ->where('id_penyedia_layanan', $layanan->id_user)
            ->latest()
            ->first();

        $detail = Pesanan_detail::where('id_pesanan', $pesanan->id)->first();

        return view('pembayaran.lanjut', compact('layanan', 'pesanan', 'detail'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|exists:pesanans,id',
            'metode_pembayaran' => 'required|string',
            'lokasi_awal' => 'nullable|string',
            'lokasi_tujuan' => 'nullable|string',
            'lokasi_kandang' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|max:2048',
        ]);

        // Simpan data pembayaran di tabel 'pembayarans' (bisa disesuaikan)
        // Lalu arahkan ke halaman selesai

        return redirect()->route('home')->with('success', 'Pembayaran berhasil diproses.');
    }
}
