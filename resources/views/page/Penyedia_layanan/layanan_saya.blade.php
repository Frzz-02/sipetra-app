@extends('layout.auth')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Layanan Saya</h2>
        <a href="{{ route('layanan.create') }}" class="btn btn-primary">Tambah Layanan</a>
    </div>

    @if($layananSaya->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki layanan. Silakan tambahkan layanan terlebih dahulu.
        </div>
    @else
        <div class="row">
            @foreach($layananSaya as $layanan)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $layanan->layanan->nama_layanan }}</h5>
                            <p class="card-text"><strong>Tipe:</strong> {{ $layanan->tipe }}</p>
                            <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($layanan->harga_dasar) }}</p>
                            <p class="card-text"><strong>Deskripsi:</strong> {{ $layanan->deskripsi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
