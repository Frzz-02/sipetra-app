<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layanan_detail;
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
            'tipe_input' => 'required|in:penitipan,antar jemput,lokasi kandang,lainnya',
            'variasi' => 'nullable|array',
            'variasi.*.nama' => 'required_with:variasi|string',
            'variasi.*.harga' => 'required_with:variasi|numeric|min:0',
            'variasi.*.opsi' => 'nullable|string',
            'variasi.*.deskripsi' => 'nullable|string|max:255',
        ]);

        $id_penyedia = DB::table('penyedia_layanans')
        ->where('id_user', Auth::id())
        ->value('id');

        DB::beginTransaction();

        try {
            $layanan = Layanan::create([
                'id_user' => Auth::id(),
                'nama_layanan' => $request->nama_layanan,
                'deskripsi' => $request->deskripsi,
                'tipe_input' => $request->tipe_input,
            ]);

            // Simpan layanan utama sebagai 1 entri default di penyedia_layanan_detail
            layanan_detail::create([
                'id_penyedia' => $id_penyedia,
                'id_layanan' => $layanan->id,
                'nama_variasi' => $request->nama_layanan,
                'harga_dasar' => $request->harga_dasar,
                'deskripsi' => $request->deskripsi ?? null,

            ]);

            // Jika ada variasi tambahan, simpan juga
            if ($request->filled('variasi')) {
                foreach ($request->variasi as $item) {
                    layanan_detail::create([
                        'id_penyedia' => $id_penyedia,
                        'id_layanan' => $layanan->id,
                        'nama_variasi' => $item['nama'],
                        'harga_dasar' => $item['harga'],
                        'deskripsi' => $item['deskripsi'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('layanansaya')->with('success', 'Layanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanansaya')->with('success', 'Layanan berhasil dihapus.');
    }
     public function edit($id)
    {
        $detail = layanan_detail::findOrFail($id);
        return view('page.penyedia_layanan.edit_detaillayanan', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipe' => 'required|string|max:50',
            'harga_dasar' => 'required|numeric|min:0',
            'opsi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $detail = layanan_detail::findOrFail($id);
        $detail->update([
            'tipe' => $request->tipe,
            'harga_dasar' => $request->harga_dasar,
            'opsi' => $request->opsi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('layanansaya')->with('success', 'Variasi layanan berhasil diperbarui.');
    }

    public function destroyvariasi($id)
    {
        $detail = layanan_detail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Variasi layanan berhasil dihapus.');
    }
    public function toggleStatus($id)
    {
        $layanan = Layanan::findOrFail($id);

        $layanan->status = $layanan->status === 'tampilkan' ? 'arsipkan' : 'tampilkan';
        $layanan->save();

        return redirect()->back()->with('success', 'Status layanan berhasil diperbarui.');
    }


}
