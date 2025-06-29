@extends('layout.main')

@section('content2')
<div class="py-4">
    <!-- Header Toko -->
    <div class="mb-5 p-4 rounded shadow-sm" style="background-color: #f9f5f3;">
        <h2 class="fw-bold mb-2" style="color: #bb9587;">
            <i class="fas fa-store me-2"></i>{{ $penyedia->nama_toko }}
        </h2>
        <p class="text-muted mb-1">
            <i class="fas fa-map-marker-alt me-2"></i> {{ $penyedia->alamat_toko }}
        </p>

        @if($penyedia->deskripsi)
        <p class="mt-3 text-dark" style="line-height: 1.7;">
            <i class="fas fa-info-circle me-2 text-secondary"></i>{{ $penyedia->deskripsi }}
        </p>
        @endif
    </div>

    <!-- Judul Layanan -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="fw-semibold" style="color: #bb9587;">Layanan Tersedia</h4>
        <hr class="flex-grow-1 ms-3" style="border-top: 2px solid #bb9587; max-width: 150px;">
    </div>

    <!-- Daftar Layanan -->
    <div class="row">
        @forelse($penyedia->layanans as $layanan)
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 service-card" style="transition: 0.3s;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title fw-bold" style="color: #333;">
                        <i class="fas fa-paw me-2 text-warning"></i>{{ $layanan->nama_layanan }}
                    </h5>
                    <p class="text-muted small mt-2">Klik untuk pesan layanan</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('pemesanan.create', $layanan->id) }}" class="btn btn-sm" style="background-color: #bb9587; color: white;">
                        Pesan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-circle me-2"></i> Penyedia ini belum memiliki layanan.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .service-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
