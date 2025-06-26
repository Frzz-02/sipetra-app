@extends('layout.auth')

@section('content')
<div class="container">
    <h3>{{ $penyedia->nama_toko }}</h3>
    <p class="text-muted">Alamat: {{ $penyedia->alamat_toko }}</p>
    <hr>
    <h5>Layanan Tersedia</h5>

    <div class="row">
        @forelse($penyedia->layanans as $layanan)
        <div class="col-md-4 mb-3">
            <div class="card h-100" style="cursor:pointer;" onclick="window.location='{{ route('layanan.detail', $layanan->id) }}'">
                <div class="card-body">
                    <h5 class="card-title">{{ $layanan->nama_layanan }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($layanan->deskripsi, 100) }}</p>
                    <p class="text-muted">Harga: Rp{{ number_format($layanan->harga_dasar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning">Penyedia ini belum memiliki layanan.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection
