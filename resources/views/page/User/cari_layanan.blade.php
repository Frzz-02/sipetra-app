@extends('layout.main')

@section('content2')
<div class="container">
    <h4 class="mb-4 font-weight-bold text-primary text-center text-md-left">Cari Penyedia Layanan</h4>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('cari_layanan') }}" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="q" class="form-control border-primary" placeholder="Cari nama toko atau lokasi" value="{{ request('q') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search me-1"></i><span class="d-none d-sm-inline">Cari</span>
            </button>
        </div>
    </form>

    {{-- Daftar Penyedia --}}
    <div class="row">
        @forelse($penyedia as $item)
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-left-primary" style="cursor: pointer;" onclick="window.location='{{ route('penyedia_layanan.detail', $item->id) }}'">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-2 d-flex align-items-center">
                        <i class="fas fa-store-alt me-2"></i>
                        <span class="text-truncate" style="max-width: 85%">{{ $item->nama_toko }}</span>
                    </h5>
                    <p class="card-text text-secondary mb-1">
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $item->alamat_toko }}
                    </p>
                    <p class="text-muted small mb-0">
                        Klik untuk lihat detail layanan →
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning shadow-sm text-center">
                <i class="fas fa-exclamation-circle me-2"></i> Tidak ada penyedia layanan ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
