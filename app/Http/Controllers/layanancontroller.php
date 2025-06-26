<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyedia_layanan_detail;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function index()
    {
        // Ambil semua layanan yang dimiliki user
        $layananUtama = \App\Models\Layanan::with('details') // relasi ke variasi
            ->where('id_user', Auth::id())
            ->get();

        return view('page.Penyedia_layanan.layanan_saya', compact('layananUtama'));
    }


    public function show($id)
    {
        $layanan = Layanan::with('details')->where('id_user', Auth::id())->findOrFail($id);
        return view('page.Penyedia_layanan.detail_layanan', compact('layanan'));
    }


    public function create()
    {
        $layananSession = session()->get('layanan_details', []);
        return view('layanan.create', compact('layananSession'));
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
            'variasi' => 'nullable|array',
            'variasi.*.nama' => 'required_with:variasi|string',
            'variasi.*.harga' => 'required_with:variasi|numeric|min:0',
            'variasi.*.opsi' => 'nullable|string',
            'variasi.*.deskripsi' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $layanan = Layanan::create([
                'id_user' => Auth::id(),
                'nama_layanan' => $request->nama_layanan,
                'deskripsi' => $request->deskripsi,
                'harga_dasar' => $request->harga_dasar,
            ]);

            if ($request->filled('variasi')) {
                foreach ($request->variasi as $item) {
                    Penyedia_layanan_detail::create([
                        'id_penyedia' => Auth::id(),
                        'id_layanan' => $layanan->id,
                        'tipe' => $item['nama'],
                        'harga_dasar' => $item['harga'],
                        'deskripsi' => $item['deskripsi'] ?? null,
                        'opsi' => $item['opsi'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('layanansaya')->with('success', 'Layanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan layanan: ' . $e->getMessage());
        }
    }

    public function resetSession()
    {
        session()->forget('variasi_layanan');
        return redirect()->route('layanan.create')->with('success', 'Daftar variasi dikosongkan.');
    }
}
