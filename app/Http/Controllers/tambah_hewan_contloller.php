<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hewan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class tambah_hewan_contloller extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:50',
            'jenis' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'berat' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:200',
            'foto' => 'required|image|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('hewan', 'public');

        // Hitung umur dari tanggal lahir
        $tanggalLahir = Carbon::parse($request->tanggal_lahir);
        $umur = $tanggalLahir->diffForHumans(null, true); // contoh: "2 tahun 3 bulan"

        Hewan::create([
            'id_user' => Auth::id(),
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $umur,
            'berat' => $request->berat,
            'deskripsi' => $request->deskripsi,
            'foto_hewan' => $fotoPath,
        ]);

        return redirect("dashboard")->with('success', 'Data hewan berhasil disimpan.');
    }
}
