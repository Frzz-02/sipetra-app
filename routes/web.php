<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/signup', [App\Http\Controllers\authcontroller::class, 'signup'])->name('signup');
Route::get('/signin', [App\Http\Controllers\authcontroller::class, 'login'])->name('signin');
Route::post('/logout', [App\Http\Controllers\authcontroller::class, 'logout'])->name('logout');

Route::post('/register', [App\Http\Controllers\authcontroller::class, 'register'])->name('register');
