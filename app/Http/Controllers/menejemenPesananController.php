<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Penyedia_layanan;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class menejemenPesananController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $penyediaId = Penyedia_layanan::where('id_user', $userId)->value('id');

        // Ambil semua layanan milik penyedia
        $layanans = Layanan::where('id_user', $userId)->get();

        // Siapkan array untuk menyimpan pesanan per layanan
        $pesananPerLayanan = [];

        foreach ($layanans as $layanan) {
            $pesanan = Pesanan::with('user')
                ->where('id_penyedia_layanan', $penyediaId)
                ->whereIn('status', ['menunggu diproses', 'diproses', 'selesai']) // ⬅ filter status
                ->whereHas('details', function ($query) use ($layanan) {
                    $query->where('id_layanan', $layanan->id);
                })
                ->orderByDesc('id')
                ->limit(8)
                ->get();

            $pesananPerLayanan[$layanan->nama_layanan] = $pesanan;
        }

        return view('page.Penyedia_layanan.pesanan', compact('pesananPerLayanan'));
    }
    public function menunggu()
{
    $userId = Auth::id();
    $penyediaId = Penyedia_layanan::where('id_user', $userId)->value('id');

    $pesanan = Pesanan::with('user', 'details.layanan_detail.layanan')
        ->where('id_penyedia_layanan', $penyediaId)
        ->where('status', 'menunggu diproses')
        ->latest()
        ->take(8)
        ->get();

    return view('page.Penyedia_layanan.pesanan_menunggu', compact('pesanan'));
}

    public function diproses()
    {
        $userId = Auth::id();
        $penyediaId = Penyedia_layanan::where('id_user', $userId)->value('id');

        $pesanan = Pesanan::with('user', 'details.layanan_detail.layanan')
            ->where('id_penyedia_layanan', $penyediaId)
            ->where('status', 'diproses')
            ->latest()
            ->take(8)
            ->get();

        return view('page.Penyedia_layanan.pesanan_diproses', compact('pesanan'));
    }

    public function selesai()
    {
        $userId = Auth::id();
        $penyediaId = Penyedia_layanan::where('id_user', $userId)->value('id');

        $pesanan = Pesanan::with('user', 'details.layanan_detail.layanan')
            ->where('id_penyedia_layanan', $penyediaId)
            ->where('status', 'selesai')
            ->latest()
            ->take(8)
            ->get();

        return view('page.Penyedia_layanan.pesanan_selesai', compact('pesanan'));
    }
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists('foto_profil/' . $user->foto_profil)) {
            Storage::disk('public')->delete('foto_profil/' . $user->foto_profil);
        }

        // Simpan foto baru
        $file = $request->file('foto_profil');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('foto_profil', $filename, 'public');
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update([
            'foto_profil' => $filename,
        ]);

        return redirect()->back()->with('success', 'Foto profil berhasil diunggah.');
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'field' => 'required|string|in:username,email,no_telephone,alamat',
            'value' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $field = $request->input('field');
        $value = $request->input('value');
         /** @var \App\Models\User $user */
        $user->$field = $value;
        $user->save();

        return response()->json(['success' => true, 'new_value' => $value]);
    }
    public function indexx()
{
    return view('page.Penyedia_layanan.profil_penyedia');
}


}
