<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\dashboard_user;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\tambah_hewan_contloller;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/signup', [App\Http\Controllers\authcontroller::class, 'signup'])->name('signup');
Route::get('/signin', [App\Http\Controllers\authcontroller::class, 'login'])->name('signin');
Route::post('/logout', [App\Http\Controllers\authcontroller::class, 'logout'])->name('logout');

Route::post('/register', [App\Http\Controllers\authcontroller::class, 'register'])->name('register');
Route::post('/signin', [App\Http\Controllers\authcontroller::class, 'signin'])->name('signin.post');
Route::post('/signup/penyedia', [App\Http\Controllers\authcontroller::class, 'registerpenyedia'])->name('registerpenyedia');

route::get('/signupreg', function () {
    return view('penyedia_layanan\regristasi_penyedia');
})->name('registrasi_penyedia');

route::get('/layanansaya', function () {
    return view('penyedia_layanan\layanan_saya');
})->name('layanansaya');



route::get('/dashboard', [App\Http\Controllers\dashboard_user::class, 'index'])->middleware(middleware: ['auth'])->name('dashboard_users');
route::get('/dashboardtoko', function () {
    return view('dashboard_penyedia_jasa');
})->middleware(['auth'])->name('dashboard_penyedia_jasa');
route::get('/tambahhewan', function () {
    return view('tambah-hewan');
})->middleware(['auth'])->name('add_hewan');


route::get('/dashboard', [App\Http\Controllers\dashboard_user::class, 'showhewan'])->middleware(middleware: ['auth'])->name('dashboard_hewan');
Route::post('/hewan/tambah', [tambah_hewan_contloller::class, 'store'])->name('hewan.store')->middleware(['auth']);

