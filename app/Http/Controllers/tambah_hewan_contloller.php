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

      if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/hewan'), $filename);
        }



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
            'foto_hewan' => $filename,
        ]);

        return redirect($request->input('redirect', route('dashboard_hewan')));
    }
}
