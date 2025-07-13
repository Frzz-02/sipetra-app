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
use App\Http\Controllers\DashboardPenyediaController;
use App\Http\Controllers\detailPesanan_penyediaJasa;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\prosesController;
use App\Http\Controllers\StatusProsesController;
use App\Http\Controllers\menejemenPesananController;
use App\Http\Controllers\laporanController;

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






//role user
Route::middleware(['auth', 'user'])->group(function () {
    route::get('/tambahhewan', function () {
        return view('page.User.tambah-hewan');
    })->middleware(['auth'])->name('add_hewan');
    route::get('/profil', function () {
        return view('page.User.profil');
    })->middleware(['auth'])->name('profil_user');
    route::get('/dashboard', [dashboard_user::class, 'showhewan'])->middleware(middleware: ['auth'])->name('dashboard_hewan')->middleware(['auth']);
    Route::post('/hewan/tambah', [tambah_hewan_contloller::class, 'store'])->name('hewan.store')->middleware(['auth']);
    Route::get('/hewan/{id}', [tambah_hewan_contloller::class, 'show'])->name('hewan.show');
    Route::get('/hewan/{id}/edit', [tambah_hewan_contloller::class, 'edit'])->name('hewan.edit');
    Route::put('/hewan/{id}', [tambah_hewan_contloller::class, 'update'])->name('hewan.update');
    Route::delete('/hewan/{id}', [tambah_hewan_contloller::class, 'destroy'])->name('hewan.destroy');
    Route::get('/riwayat-pesanan', [dashboard_user::class, 'riwayat'])->name('riwayat.pesanan');
    Route::get('penyedia/proses/{id_pesanan}', [dashboard_user::class, 'detailProsesPesanan'])->name('penyedia.proses.detail');
    Route::patch('/pesanan/{id}/batal', [dashboard_user::class, 'batalPesanan'])->name('pesanan.batal');
    Route::get('/cari-layanan', [CariLayananController::class, 'index'])->name('cari_layanan');
    Route::get('/penyedia/{id}', [CariLayananController::class, 'detail'])->name('penyedia_layanan.detail');
    Route::get('/layanan/{id}/detail_layanan', [CariLayananController::class, 'show'])->name('layanan.detail');
    Route::get('/pemesanan/{id_layanan}', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan/{id_layanan}', [PemesananController::class, 'store'])->name('pemesanan.store');
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
});











//-role penyedia
Route::middleware(['auth', 'penyedia'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/tambah', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::post('/pesanan/{id}/proses', [prosesController::class, 'prosesPesanan'])->name('pesanan.proses');
    Route::get('/penugasan/{id}', [prosesController::class, 'formPenugasan'])->name('penugasan.form');
    Route::post('/penugasan/{id}/simpan', [prosesController::class, 'simpanPenugasan'])->name('penugasan.simpan');
    Route::get('status-proses/{id}/tambah', [StatusProsesController::class, 'formTambah'])->name('status.tambah.form');
    Route::post('status-proses/{id}/simpan', [StatusProsesController::class, 'simpan'])->name('simpan.tambah.form');
    Route::post('/pesanan/{id}/selesai', [prosesController::class, 'selesaikanPesanan'])->name('pesanan.selesai');
    Route::get('/pesanan', [menejemenPesananController::class, 'index'])->name('pesanantoko');
    Route::get('/pesanan/menunggu', [menejemenPesananController::class, 'menunggu'])->name('pesanantoko.menunggu');
    Route::get('/pesanan/diproses', [menejemenPesananController::class, 'diproses'])->name('pesanantoko.diproses');
    Route::get('v/selesai', [menejemenPesananController::class, 'selesai'])->name('pesanantoko.selesai');
    Route::get('/penyedia/{id}/lapor', [laporanController::class, 'create'])->name('laporan.create');
    Route::post('/penyedia/{id}/lapor', [laporanController::class, 'store'])->name('laporan.store');

    Route::get('/layanansaya', [layanancontroller::class, 'index'])->name('layanansaya');
    Route::get('/layanan/{id}/detaillayanan', [LayananController::class, 'show'])->name('layanan.detaillayanan');
    Route::get('/layanan/tambah', [LayananController::class, 'createLayanan'])->name('layanan.create');
    Route::post('/layanan/tambah', [LayananController::class, 'storeLayanan'])->name('layanan.store');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
    Route::get('/layanan/detail/{id}/edit', [LayananController::class, 'edit'])->name('detail_layanan.edit');
    Route::put('/layanan/detail/{id}', [LayananController::class, 'update'])->name('detail_layanan.update');
    Route::delete('/layanan/detail/{id}', [LayananController::class, 'destroyvariasi'])->name('detail_layanan.destroy');
    Route::put('/layanan/{id}/toggle-status', [LayananController::class, 'toggleStatus'])->name('layanan.toggleStatus');

    Route::get('/dashboardpenyedia', [DashboardPenyediaController::class, 'index'])->name('penyedia.dashboard');
    Route::get('/penyedia/pesanan/{id}', [detailPesanan_penyediaJasa::class, 'show'])->name('penyedia.pesanan.detail');
    Route::put('/pesanan/{id}/batalkan', [detailPesanan_penyediaJasa::class, 'batalkan'])->name('pesanan.batalkan');
    Route::get('tampilantoko', [dashboardPenyediaController::class, 'tampilantoko'])->name('tampilantoko');
    Route::put('/penyedia/{id}', [dashboardPenyediaController::class, 'update'])->name('penyedia.update');
    Route::get('/penyedia/{id}/edit', [dashboardPenyediaController::class, 'edit'])->name('penyedia.edit');
    Route::delete('/penyedia/{id}/hapus-foto', [dashboardPenyediaController::class, 'deleteFoto'])->name('penyedia.deleteFoto');
    Route::post('/penyedia/{id}/update-field', [dashboardPenyediaController::class, 'updateField'])
        ->name('penyedia.updateField');
    Route::post('/penyedia/{id}/inline-update', [dashboardPenyediaController::class, 'inlineUpdate'])->name('penyedia.inlineUpdate');
    Route::post('/penyedia/{id}/upload-foto', [dashboardPenyediaController::class, 'uploadFoto'])->name('penyedia.uploadFoto');
    Route::delete('/penyedia/foto/{id}', [dashboardPenyediaController::class, 'hapusFoto'])->name('penyedia.fotoHapus');
    Route::get('/penyedia/ulasan', [dashboardPenyediaController::class, 'ulasan'])->name('penyedia.ulasan');

});
