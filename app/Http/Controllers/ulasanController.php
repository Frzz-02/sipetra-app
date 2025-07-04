<?php
namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Penyedia_layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function create($id_penyedia)
    {
        $penyedia = Penyedia_layanan::findOrFail($id_penyedia);
        return view('page.User.ulasan_form', compact('penyedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penyedia' => 'required|exists:penyedia_layanans,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Ulasan::create([
            'id_user' => Auth::id(),
            'id_penyedia' => $request->id_penyedia,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
    public function detail($id)
    {
        $penyedia = Penyedia_layanan::with(['ulasan.user'])->findOrFail($id);
        return view('page.User.detail_penyedia', compact('penyedia'));
    }

}
