<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Pesanan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function lanjut($id_pesanan)
    {
        $pesanan = Pesanan::with([
            'details.hewan', // Ambil data hewan
            'details.layanan', // Ambil layanan dari detail
            'penyediaLayanan', // jika ingin info toko
        ])->findOrFail($id_pesanan);

        // Ambil layanan dari salah satu detail (karena semua sama id_layanan-nya)
        $layanan = optional($pesanan->details->first())->layanan;

        return view('page.User.pembayaran', compact('pesanan', 'layanan'));
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
