@extends('layout.auth')

@section('content')
<div class="container mt-5">
    <h2>Detail Layanan: {{ $layanan->nama_layanan }}</h2>

    <p><strong>Deskripsi:</strong> {{ $layanan->deskripsi ?? '-' }}</p>
    <p><strong>Harga Dasar:</strong> Rp {{ number_format($layanan->harga_dasar) }}</p>

    <hr>
    <h4>Variasi Layanan</h4>

    @if($layanan->details->isEmpty())
        <p>Tidak ada variasi layanan.</p>
    @else
        <ul class="list-group">
            @foreach($layanan->details as $detail)
                <li class="list-group-item">
                    <strong>Tipe:</strong> {{ $detail->tipe }} |
                    <strong>Harga:</strong> Rp {{ number_format($detail->harga_dasar) }} <br>
                    <strong>Deskripsi:</strong> {{ $detail->deskripsi ?? '-' }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('layanansaya') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
