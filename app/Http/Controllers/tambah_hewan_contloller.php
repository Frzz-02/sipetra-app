<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hewan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class tambah_hewan_contloller extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:50',
            'jenis' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'berat' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:betina,jantan',
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
            'jenis_kelamin' => $request->jenis_kelamin,
            'deskripsi' => $request->deskripsi,
            'foto_hewan' => $filename,
        ]);

        return redirect($request->input('redirect', route('dashboard_hewan')));
    }
    public function show($id)
    {
        $hewan = \App\Models\Hewan::findOrFail($id);
        return view('page.User.detail_hewan', compact('hewan'));
    }

    public function edit($id)
    {
        $hewan = Hewan::where('id_user', Auth::id())->findOrFail($id);
        return view('page.User.edit_hewan', compact('hewan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:100',
            'jenis_hewan' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|string',
            'berat' => 'required|string',
            'Jenis_kelamin' => 'required',
            'deskripsi' => 'nullable|string',
            'foto_hewan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $hewan = Hewan::where('id_user', Auth::id())->findOrFail($id);

        $hewan->nama_hewan = $request->nama_hewan;
        $hewan->jenis_hewan = $request->jenis_hewan;
        $hewan->tanggal_lahir = $request->tanggal_lahir;
        $hewan->umur = $request->umur;
        $hewan->berat = $request->berat;
        $hewan->jenis_kelamin = $request->Jenis_kelamin;
        $hewan->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_hewan')) {
            // Hapus file lama jika ada
            if ($hewan->foto_hewan && Storage::exists('public/assets/hewan/' . $hewan->foto_hewan)) {
                Storage::delete('public/assets/hewan/' . $hewan->foto_hewan);
            }

            $foto = $request->file('foto_hewan');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/assets/hewan', $filename);
            $hewan->foto_hewan = $filename;
        }

        $hewan->save();

        return redirect()->route('hewan.show', $hewan->id)->with('success', 'Data hewan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $hewan = Hewan::findOrFail($id);

        // Pastikan user hanya bisa menghapus hewan miliknya
        if ($hewan->id_user !== auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        // Hapus foto dari storage jika perlu
        $fotoPath = public_path('assets/hewan/' . $hewan->foto_hewan);
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        $hewan->delete();

        return redirect()->route('dashboard_hewan')->with('success', 'Data hewan berhasil dihapus.');
    }

}
