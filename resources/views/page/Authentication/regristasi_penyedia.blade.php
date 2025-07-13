@extends('layout.auth')

@push('styles')
<style>
    body, html {
        height: 100%;
        margin: 0;
        background: #bb9587;
        font-family: 'Poppins', sans-serif;
    }
    h2 {
        font-family: 'Fredoka One', cursive;
        font-size: 2rem;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #c9a99a;
    }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 px-3" style="background: #bb9587;">
    <div class="bg-white rounded-4 shadow p-4 p-md-5 w-100" style="max-width: 500px;">
        <h2 class="text-center mb-3 text-dark">Daftar Penyedia Layanan</h2>
        <p class="text-center text-muted small mb-4">Isi data pemilik dan toko layanan Anda</p>

        <form action="{{ route('registerpenyedia') }}" method="POST" enctype="multipart/form-data" class="small text-muted">
            @csrf

            <!-- Data Pemilik -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pemilik <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control form-control-sm" placeholder="Nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control form-control-sm" placeholder="contoh@email.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control form-control-sm" placeholder="Masukkan password" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                <input type="tel" name="no_telephone" class="form-control form-control-sm" placeholder="08xxxxxxxxxx" required>
            </div>

            <hr class="text-muted">

            <!-- Data Toko -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Toko <span class="text-danger">*</span></label>
                <input type="text" name="nama_toko" class="form-control form-control-sm" placeholder="Nama toko layanan Anda" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Toko <span class="text-danger">*</span></label>
                <textarea name="alamat_toko" rows="2" class="form-control form-control-sm" placeholder="Contoh: Jl. Kartini No.44, Surabaya" required></textarea>
            </div>

             <div class="mb-4">
                <label class="form-label fw-semibold">Logo Toko <small class="text-muted">(Opsional)</small></label>
                <input type="file" name="logo_toko" class="form-control form-control-sm" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Toko <small class="text-muted">(Opsional)</small></label>
                <textarea name="deskripsi" rows="3" class="form-control form-control-sm" placeholder="Jelaskan layanan atau keunggulan toko Anda..."></textarea>
            </div>



            <button type="submit" class="btn w-100 text-white fw-semibold mb-2" style="background-color: #c9a99a;">Daftar</button>

            <!-- Tombol kembali ke login -->
            <div class="text-center">
                <a href="{{ route('signin') }}" class="text-decoration-none small" style="color: #bb9587;">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
