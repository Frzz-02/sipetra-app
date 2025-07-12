<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Penyedia_layanan;

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
}
