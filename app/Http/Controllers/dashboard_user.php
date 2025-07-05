<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hewan;
use App\Models\Pesanan;

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
         $pesanans = \App\Models\Pesanan::with(['details.layanan'])
        ->where('id_user', auth::user()->id)
        ->orderByDesc('id') // urut dari ID tertinggi (pesanan terbaru)
        ->get();

        return view('page.User.riwayat', compact('pesanans'));
    }
    public function riwayat_detail($id)
        {
            $pesanan = Pesanan::with(['details.layanan', 'details.hewan', 'penyediaLayanan'])
                ->where('id', $id)
                ->where('id_user', auth::user()->id)
                ->firstOrFail();

            $biayaPotongan = $pesanan->total_biaya * 0.1;
             $biayaTotal = $pesanan->total_biaya + $biayaPotongan;

            return view('page.User.riwayat_detail', compact('pesanan', 'biayaPotongan', 'biayaTotal'));
        }



}
