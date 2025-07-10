@extends('layout.main')

@section('content2')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Detail Proses Pesanan</h3>

    {{-- Informasi Pesanan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Informasi Pesanan</h5>
            <p><strong>ID Pesanan:</strong> {{ $sedangProses->pesanan->id }}</p>
            <p><strong>Status Pesanan:</strong> {{ ucfirst($sedangProses->pesanan->status) }}</p>
        </div>
    </div>

    {{-- Catatan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Catatan Penugasan</h5>
            <p>{{ $sedangProses->catatan ?? '-' }}</p>
        </div>
    </div>

    {{-- Karyawan yang Menangani --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Petugas yang Menangani</h5>
            @forelse ($sedangProses->petugas as $petugas)
                <div class="mb-2">
                    <strong>{{ $petugas->karyawan->nama }}</strong> – {{ $petugas->karyawan->tipe_karyawan ?? 'Umum' }}
                </div>
            @empty
                <p class="text-muted">Belum ada petugas ditugaskan.</p>
            @endforelse
        </div>
    </div>

    {{-- Riwayat Status Proses --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Riwayat Status Proses</h5>
            @forelse ($sedangProses->status_proses as $status)
                <div class="mb-2">
                    <strong>Status:</strong> {{ ucfirst($status->status) }} <br>
                    <small class="text-muted">Waktu: {{ $status->waktu }}</small>
                </div>
            @empty
                <p class="text-muted">Belum ada status proses tercatat.</p>
            @endforelse
        </div>
    </div>

    <div class="text-end">
        <a href="{{ route('pesanan.detail',$sedangProses->id_pesanan) }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>
@endsection
