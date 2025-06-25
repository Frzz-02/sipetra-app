<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyedia_layanan_detail;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function index()
    {
        $layananSaya = Penyedia_layanan_detail::with('layanan')
            ->where('id_penyedia', Auth::id())
            ->get();

        return view('page.Penyedia_layanan.layanan_saya', compact('layananSaya'));
    }

    public function create()
    {
        $layananSession = session()->get('layanan_details', []);
        return view('layanan.create', compact('layananSession'));
    }

    public function addToSession(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'opsi' => 'nullable|string',
        ]);

        $variasi = session()->get('variasi_layanan', []);

        $variasi[] = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'opsi' => $request->opsi,
        ];

        session(['variasi_layanan' => $variasi]);

        return back()->with('success', 'Variasi berhasil ditambahkan ke daftar sementara.');
    }

    public function createLayanan()
    {
        $variasi = session()->get('variasi_layanan', []);
        return view('page.penyedia_layanan.form_layanan', compact('variasi'));
    }

    public function storeLayanan(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'harga_dasar' => 'required|numeric|min:0',
            'variasi' => 'required|array|min:1',
            'variasi.*.nama' => 'required|string',
            'variasi.*.harga' => 'required|numeric|min:0',
            'variasi.*.opsi' => 'nullable|string',
        ]);

        // Simpan layanan utama
        $layanan = Layanan::create([
            'id_user' => Auth::id(), // pastikan ini sesuai field di tabel
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga_dasar' => $request->harga_dasar,
        ]);

        // Simpan variasi layanan
        foreach ($request->variasi as $item) {
            Penyedia_layanan_detail::create([
                'id_penyedia' => Auth::id(),
                'id_layanan' => $layanan->id,
                'tipe' => $item['nama'],
                'harga_dasar' => $item['harga'],
                'deskripsi' => $item['opsi'] ?? null,
            ]);
        }

        return redirect()->route('layanansaya')->with('success', 'Layanan berhasil ditambahkan!');
    }


    public function resetSession()
    {
        session()->forget('variasi_layanan');
        return redirect()->route('layanan.create')->with('success', 'Daftar variasi dikosongkan.');
    }
}
