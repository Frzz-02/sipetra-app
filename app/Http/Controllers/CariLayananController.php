<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Models\Penyedia_layanan;
use App\Models\layanan_detail;


class CariLayananController extends Controller
{
    public function index()
    {
        // Ambil semua penyedia layanan dari DB
       $penyedia = Penyedia_layanan::with(['fotos', 'layanans'])
        ->whereHas('layanans')
        ->get();

        return view('page.User.cari_layanan', compact('penyedia'));
    }

    public function detail($id)
    {
        $penyedia = Penyedia_layanan::with('layanans')->findOrFail($id);
        return view('page.User.detail_penyedia', compact('penyedia'));
    }
    public function show($id)
    {
        $layanan = layanan_detail::findOrFail($id);

        return view('page.User.detail_layanan', compact('layanan'));
    }
    public function search(Request $request)
    {
        $query = Penyedia_Layanan::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q1) use ($search) {
                $q1->where('nama_toko', 'like', "%{$search}%")
                    ->orWhere('alamat_toko', 'like', "%{$search}%");
            })
            ->orWhereHas('layanans', function ($q2) use ($search) {
                $q2->where('nama_layanan', 'like', "%{$search}%");
            });
        }

        $penyedia = $query->latest()->get();

        return view('page.User.cari_layanan', compact('penyedia'));
    }


}
