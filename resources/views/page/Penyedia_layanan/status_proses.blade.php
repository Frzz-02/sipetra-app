@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Tambah Riwayat Status</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('simpan.tambah.form', $sedangProses->id) }}" method="POST">
                @csrf

                {{-- Informasi Terkait --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">ID Pesanan</label>
                    <input type="text" class="form-control" value="{{ $sedangProses->pesanan->id }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status Baru</label>
                    <input type="text" name="status" class="form-control" id="status" placeholder="Contoh: sedang dijemput" required>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Waktu</label>
                    <input type="text" class="form-control" value="{{ now()->format('Y-m-d H:i:s') }}" readonly>
                </div>

                <div class="text-end">
                    <a href="{{ route('penyedia.pesanan.detail', $sedangProses->pesanan->id) }}" class="btn btn-outline-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">
                        Simpan Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
