@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Form Penugasan Petugas</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('penugasan.simpan', $sedangProses->id) }}" method="POST">
        @csrf

        {{-- Daftar Karyawan --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Pilih Karyawan yang Akan Menangani</h5>

                @forelse ($karyawans as $karyawan)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="karyawan_ids[]" value="{{ $karyawan->id }}" id="karyawan{{ $karyawan->id }}">
                        <label class="form-check-label" for="karyawan{{ $karyawan->id }}">
                            <strong>{{ $karyawan->nama }}</strong> – {{ $karyawan->tipe_karyawan ?? 'Umum' }}
                        </label>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada karyawan tersedia.</p>
                @endforelse

                @error('karyawan_ids') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Catatan --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Catatan (Opsional)</h5>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika ada...">{{ old('catatan') }}</textarea>
            </div>
        </div>

        {{-- Status Proses --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Status Proses</h5>
                <input type="text" name="status" class="form-control" value="diproses" placeholder="Status proses" required>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Waktu (Real Time) --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Waktu Penugasan</h5>
                <input type="text" class="form-control" value="{{ now()->format('Y-m-d H:i:s') }}" readonly>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="text-end">
            <a href="#" class="btn btn-outline-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary" style="background-color: #003366; border-color: #003366;">
                Simpan Penugasan
            </button>
        </div>
    </form>
</div>
@endsection
