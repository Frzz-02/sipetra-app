<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Penyedia_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class karyawanController extends Controller
{
    public function index()
    {

        $idPenyedia = Penyedia_layanan::where('id_user', Auth::id())->value('id');

        $karyawan = Karyawan::where('id_penyedia_layanan', $idPenyedia)->get();
        return view('page.Penyedia_layanan.karyawan', compact('karyawan'));
    }
    // Tampilkan form tambah karyawan
    public function create()
    {
        return view('page.Penyedia_layanan.add_karyawan');
    }

    // Simpan data karyawan baru
public function store(Request $request)
{
    $request->validate([
        'foto_karyawan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'nama' => 'required|string|max:45',
        'email' => 'required|email|max:35|unique:karyawans,email',
        'no_telephone' => 'required|string|max:15',
        'alamat' => 'required|string',
        'tipe_karyawan' => 'nullable|string|max:20',
    ]);

    $idPenyedia = Penyedia_layanan::where('id_user', Auth::id())->value('id');

    $fotoPath = null;

    if ($request->hasFile('foto_karyawan')) {
        $file = $request->file('foto_karyawan');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/karyawan'), $filename);
        $fotoPath = 'assets/karyawan/' . $filename;
    }

    Karyawan::create([
        'id_penyedia_layanan' => $idPenyedia,
        'nama' => $request->nama,
        'email' => $request->email,
        'no_telephone' => $request->no_telephone,
        'alamat' => $request->alamat,
        'tipe_karyawan' => $request->tipe_karyawan,
        'status' => 'tidak bertugas',
        'foto_karyawan' => $fotoPath,
    ]);

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
}


}
