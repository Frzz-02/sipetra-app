<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hewan;

class dashboard_user extends Controller
{
    public function index()
    {
        return view('page.User.dashboard_users');
    }
    public function showhewan()
    {
        $user = Auth::user(); // user yang login

        $hewan = Hewan::where('id_user', $user->id)->get();

       return view('page.User.dashboard_users', compact('hewan'));
    }


}
