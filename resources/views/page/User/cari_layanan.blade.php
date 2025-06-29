@extends('layout.main')

@section('content2')
<div class="container">
    <h4 class="mb-3">Cari Penyedia Layanan</h4>

    <form method="GET" action="{{ route('cari_layanan') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari berdasarkan nama toko atau lokasi" value="{{ request('q') }}">
            <button class="btn btn-outline-primary" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>

    <div class="row">
        @forelse($penyedia as $item)
        <div class="col-md-4 mb-3">
            <div class="card h-100" style="cursor:pointer;" onclick="window.location='{{ route('penyedia_layanan.detail', $item->id) }}'">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_toko }}</h5>
                    <p class="card-text text-muted">Lokasi: {{ $item->alamat }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning">Tidak ada penyedia layanan ditemukan.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection
