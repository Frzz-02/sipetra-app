@extends('layout.auth')

@section('content')
<div class="container">
    <h3>{{ $layanan->nama_layanan }}</h3>
    <p class="text-muted">{{ $layanan->deskripsi }}</p>
    <hr>
    <p>Harga: Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>

    <a href="{{ route('cari_layanan') }}" class="btn btn-secondary mt-3">Kembali ke Cari Layanan</a>
</div>
@endsection
