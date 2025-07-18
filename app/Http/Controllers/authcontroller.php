<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyedia_layanan;
class authcontroller extends Controller
{
    public function signup()
    {
        return view('page.Authentication.signup');
    }

    public function login()
    {
        return view('page.Authentication.signin');
    }

    public function logout()
    {
        Auth::logout(); // Logout user
        request()->session()->invalidate(); // Hancurkan session
        request()->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
    public function register(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'username'      => 'required|string|max:255',
            'no_telephone'  => 'required|string|max:20',
            'alamat'        => 'nullable|string|max:255',
        ]);

        // Simpan user
        User::create([
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'username'      => $validated['username'],
            'no_telephone'  => $validated['no_telephone'],
            'alamat'        => $validated['alamat'] ?? null,
            'role'          => 'user',
        ]);

        return redirect("login")->with('success', 'Registrasi berhasil!');
    }

     public function signin(Request $request)
        {
            // Validasi
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Coba login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Cek role setelah login berhasil
                $user = Auth::user();

                if ($user->role === 'user') {
                    return redirect('dashboard');
                } elseif ($user->role === 'penyedia_jasa') {
                    return redirect()->route('penyedia.dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors(['role' => 'Role tidak dikenali.']);
                }
            }

            // Jika gagal
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }
    public function registerpenyedia(Request $request)
    {

        // Validasi data
        $validated = $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'username'      => 'required|string|max:255',
            'no_telephone'  => 'required|string|max:20',
        ]);


        $user = User::create([
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'username'      => $validated['username'],
            'no_telephone'  => $validated['no_telephone'],
            'role'          => 'penyedia_jasa',
        ]);
        Penyedia_Layanan::create([
            'id_user' => $user->id,
            'nama_toko' => $request->nama_toko,
            'alamat_toko' => $request->alamat_toko,
            'deskripsi' => $request->deskripsi,
            'color_heading' => '#fdf8f6',            // <-- ganti sesuai permintaan
            'color_font_judul' => '#bb9587',
            'color_font' => '#000000',
            'color_button' => '#bb9587',
        ]);



        return redirect("login")->with('success', 'Registrasi berhasil!');
    }
}
