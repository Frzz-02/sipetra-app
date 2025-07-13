<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyedia_layanan;
use App\Models\laporan_penyedia;
use Illuminate\Support\Facades\Auth;

class laporanController extends Controller
{
    public function create($id)
    {
        $penyedia = Penyedia_layanan::findOrFail($id);
        return view('page.User.laporan_penyedia', compact('penyedia'));
    }

    public function store(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|max:1000',
    ]);

    laporan_penyedia::create([
        'id_user' => auth::user()->id,
        'id_penyedia' => $id,
        'alasan' => $request->alasan,
    ]);

    return redirect()->route('penyedia_layanan.detail', $id)->with('laporan_success', 'Laporan berhasil dikirim.');
}
}
