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

        $filename = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Simpan ke storage/app/public/foto_hewan
            $file->storeAs('foto_hewan', $filename, 'public');
        }

        // Hitung umur dari tanggal lahir
        $tanggalLahir = Carbon::parse($request->tanggal_lahir);
        $umur = $tanggalLahir->diffForHumans(null, true);

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

    public function updateField(Request $request, $id)
{
    $hewan = Hewan::findOrFail($id);
    $field = $request->input('field');
    $value = $request->input('value');

    if (in_array($field, ['nama_hewan', 'jenis_hewan', 'berat', 'deskripsi'])) {
        $hewan->$field = $value;
        $hewan->save();

        return response()->json(['success' => true, 'new_value' => $value]);
    }

    return response()->json(['success' => false], 400);
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
    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto_hewan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $hewan = Hewan::findOrFail($id);

        // Hapus foto lama jika ada
        if ($hewan->foto_hewan && Storage::disk('public')->exists('foto_hewan/' . $hewan->foto_hewan)) {
            Storage::disk('public')->delete('foto_hewan/' . $hewan->foto_hewan);
        }

        $file = $request->file('foto_hewan');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Simpan di storage/app/public/foto_hewan
        $file->storeAs('foto_hewan', $filename, 'public');

        $hewan->foto_hewan = $filename;
        $hewan->save();

        return redirect()->back()->with('success', 'Foto hewan berhasil diperbarui.');
    }



}
