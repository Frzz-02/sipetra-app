<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hewan;
use Illuminate\Support\Facades\Auth;

class tambah_hewan_contloller extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:50',
            'jenis' => 'required|string|max:50',
            'umur' => 'required|string|max:20',
            'berat' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:200',
            'foto' => 'required|image|max:2048', // maksimal 2MB
        ]);

        // Simpan foto
        $fotoPath = $request->file('foto')->store('hewan', 'public');

        // Simpan data ke DB
        Hewan::create([
            'id_user' => Auth::id(), // pastikan user sudah login
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis,
            'umur' => $request->umur,
            'berat' => $request->berat,
            'deskripsi' => $request->deskripsi,
            'foto_hewan' => $fotoPath,
        ]);

        return redirect("dashboard")->with('success', 'Data hewan berhasil disimpan.');
    }
}
