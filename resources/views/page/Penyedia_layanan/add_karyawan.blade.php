@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Tambah Karyawan</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">
        @csrf

        <div class="mb-3">
            <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
            <input type="file" name="foto_karyawan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="no_telephone" class="form-label">No. Telepon</label>
            <input type="text" name="no_telephone" class="form-control" value="{{ old('no_telephone') }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tipe_karyawan" class="form-label">Tipe Karyawan</label>
            <input type="text" name="tipe_karyawan" class="form-control" value="{{ old('no_telephone') }}" required>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
