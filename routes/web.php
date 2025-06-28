<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\dashboard_user;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\tambah_hewan_contloller;
use App\Http\Controllers\layanancontroller;
use App\Http\Controllers\CariLayananController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MidtransController;

 Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('/signup', [App\Http\Controllers\authcontroller::class, 'signup'])->name('signup');
Route::get('/login', [App\Http\Controllers\authcontroller::class, 'login'])->name('signin');
Route::post('/logout', [App\Http\Controllers\authcontroller::class, 'logout'])->name('logout');


Route::post('/register', [App\Http\Controllers\authcontroller::class, 'register'])->name('register');
Route::post('/signin', [App\Http\Controllers\authcontroller::class, 'signin'])->name('signin.post');
Route::post('/signup/penyedia', [App\Http\Controllers\authcontroller::class, 'registerpenyedia'])->name('registerpenyedia');


route::get('/signupreg', function () {
    return view('page.Authentication.regristasi_penyedia');
})->name('registrasi_penyedia');


route::get('/dashboard', [App\Http\Controllers\dashboard_user::class, 'index'])->middleware(middleware: ['auth'])->name('dashboard_users');
route::get('/dashboardtoko', function () {
    return view('page.Penyedia_layanan.dashboard_penyedia_jasa');
})->middleware(['auth'])->name('dashboard_penyedia_jasa');

route::get('/tambahhewan', function () {
    return view('page.User.tambah-hewan');
})->middleware(['auth'])->name('add_hewan');


route::get('/dashboard', [App\Http\Controllers\dashboard_user::class, 'showhewan'])->middleware(middleware: ['auth'])->name('dashboard_hewan');
Route::post('/hewan/tambah', [tambah_hewan_contloller::class, 'store'])->name('hewan.store')->middleware(['auth']);
Route::get('/riwayat-pesanan', [dashboard_user::class, 'riwayat'])->name('riwayat.pesanan');


Route::get('/layanansaya', [layanancontroller::class, 'index'])->name('layanansaya');
Route::get('/layanan/{id}/detaillayanan', [LayananController::class, 'show'])->name('layanan.detaillayanan');
Route::get('/layanan/tambah', [LayananController::class, 'createLayanan'])->name('layanan.create');
Route::post('/layanan/tambah', [LayananController::class, 'storeLayanan'])->name('layanan.store');

Route::get('/cari-layanan', [CariLayananController::class, 'index'])->name('cari_layanan');
Route::get('/penyedia/{id}', [CariLayananController::class, 'detail'])->name('penyedia_layanan.detail');
Route::get('/layanan/{id}/detail_layanan', [CariLayananController::class, 'show'])->name('layanan.detail');

Route::get('/pemesanan/{id_layanan}', [PemesananController::class, 'create'])->name('pemesanan.create');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/pembayaran/lanjutkan/{id_pesanan}', [PembayaranController::class, 'lanjut'])->name('pembayaran.lanjutkan');
Route::post('/pembayaran/proses', [PembayaranController::class, 'proses'])->name('pembayaran.proses');

Route::get('/midtrans/bayar/{id_pesanan}', [MidtransController::class, 'getSnapToken'])->name('midtrans.bayar');





