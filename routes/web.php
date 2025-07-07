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
use App\Http\Controllers\ulasanController;
use App\Http\Controllers\dashboardPenyediaController;

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



Route::get('/dashboardpenyedia', [dashboardPenyediaController::class, 'index'])->name('penyedia.dashboard');

route::get('/tambahhewan', function () {
    return view('page.User.tambah-hewan');
})->middleware(['auth'])->name('add_hewan');

route::get('/profil', function () {
    return view('page.User.profil');
})->middleware(['auth'])->name('profil_user');


route::get('/dashboard', [App\Http\Controllers\dashboard_user::class, 'showhewan'])->middleware(middleware: ['auth'])->name('dashboard_hewan');
Route::post('/hewan/tambah', [tambah_hewan_contloller::class, 'store'])->name('hewan.store')->middleware(['auth']);
Route::get('/hewan/{id}', [tambah_hewan_contloller::class, 'show'])->name('hewan.show');
Route::get('/hewan/{id}/edit', [tambah_hewan_contloller::class, 'edit'])->name('hewan.edit');
Route::put('/hewan/{id}', [tambah_hewan_contloller::class, 'update'])->name('hewan.update');
Route::delete('/hewan/{id}', [tambah_hewan_contloller::class, 'destroy'])->name('hewan.destroy');
Route::get('/riwayat-pesanan', [dashboard_user::class, 'riwayat'])->name('riwayat.pesanan');


Route::get('/layanansaya', [layanancontroller::class, 'index'])->name('layanansaya');
Route::get('/layanan/{id}/detaillayanan', [LayananController::class, 'show'])->name('layanan.detaillayanan');
Route::get('/layanan/tambah', [LayananController::class, 'createLayanan'])->name('layanan.create');
Route::post('/layanan/tambah', [LayananController::class, 'storeLayanan'])->name('layanan.store');
Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
Route::get('/layanan/detail/{id}/edit', [LayananController::class, 'edit'])->name('detail_layanan.edit');
Route::put('/layanan/detail/{id}', [LayananController::class, 'update'])->name('detail_layanan.update');
Route::delete('/layanan/detail/{id}', [LayananController::class, 'destroyvariasi'])->name('detail_layanan.destroy');


Route::get('/cari-layanan', [CariLayananController::class, 'index'])->name('cari_layanan');
Route::get('/penyedia/{id}', [CariLayananController::class, 'detail'])->name('penyedia_layanan.detail');
Route::get('/layanan/{id}/detail_layanan', [CariLayananController::class, 'show'])->name('layanan.detail');

Route::get('/pemesanan/{id_layanan}', [PemesananController::class, 'create'])->name('pemesanan.create');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/pembayaran/lanjutkan/{id_pesanan}', [PembayaranController::class, 'lanjut'])->name('pembayaran.lanjutkan');
Route::post('/pembayaran/proses', [PembayaranController::class, 'proses'])->name('pembayaran.proses');

Route::get('/midtrans/bayar/{id_pesanan}', [MidtransController::class, 'getSnapToken'])->name('midtrans.bayar');
Route::get('/penyedia', [CariLayananController::class, 'search'])->name('search.penyedia');
Route::get('/midtrans/callback', [MidtransController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/ulasan/{id_penyedia}', [ulasanController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan', [ulasanController::class, 'store'])->name('ulasan.store');
});

Route::post('/pesanan/update-status/{id}', [PembayaranController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');

Route::get('/riwayat/{id}', [dashboard_user::class, 'riwayat_detail'])->name('pesanan.detail');





