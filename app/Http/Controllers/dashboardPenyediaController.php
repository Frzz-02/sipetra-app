<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Pesanan;

class dashboardPenyediaController extends Controller
{
    public function index()
    {
        $userId = auth::user()->id;

        $jumlah_layanan = Layanan::where('id_user', $userId)->count();
        $jumlah_pesanan = Pesanan::where('id_penyedia_layanan', $userId)->count();
        $total_pendapatan = Pesanan::where('id_penyedia_layanan', $userId)
            ->where('status', 'selesai')
            ->sum('total_biaya');

        $pesanan_terbaru = Pesanan::with('user')
            ->where('id_penyedia_layanan', $userId)
            ->whereNotIn('status', ['menunggu pembayaran', 'batal']) // contoh tambahan
            ->orderByDesc('created_at')
            ->get();


        return view('page.Penyedia_layanan.dashboard_penyedia_jasa', compact(
            'jumlah_layanan',
            'jumlah_pesanan',
            'total_pendapatan',
            'pesanan_terbaru'
        ));
    }

}
