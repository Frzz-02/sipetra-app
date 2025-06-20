<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class authcontroller extends Controller
{
    public function signup()
    {
        return view('signup');
    }

    public function login()
    {
        return view('signin');
    }

    public function logout()
    {
        // Logic for logging out the user
        return redirect('/'); // Redirect to home or login page after logout
    }
    public function register(Request $request)
    {

        // Validasi data
        $validated = $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'username'      => 'required|string|max:255',
            'no_telephone'  => 'required|string|max:20',
        ]);


        User::create([
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'username'      => $validated['username'],
            'no_telephone'  => $validated['no_telephone'],
            'role'          => 'user',
        ]);


        return redirect("signin")->with('success', 'Registrasi berhasil!');
    }
}
