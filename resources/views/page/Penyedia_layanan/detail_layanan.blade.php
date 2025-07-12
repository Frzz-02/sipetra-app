@extends('layout.layout_penyedia')

@section('content2')
<style>
    .btn-custom {
        background-color: #bb9587;
        color: white;
        border: none;
        transition: 0.3s;
    }

    .btn-custom:hover {
        background-color: #a37d6f;
    }

    .btn-outline-custom {
        color: #bb9587;
        border: 1px solid #bb9587;
        background-color: transparent;
        transition: 0.3s;
    }

    .btn-outline-custom:hover {
        background-color: #d9b8ae;
        color: white;
        border-color: #a37d6f;
    }

    .list-group-item {
        border-radius: 10px;
        margin-bottom: 10px;
        background-color: #fdf9f8;
        border: 1px solid #e0d2ce;
    }

    .item-header {
        font-weight: bold;
        color: #bb9587;
    }

    .detail-label {
        font-weight: 500;
    }

    @media (max-width: 576px) {
        h2, h4 {
            font-size: 1.25rem;
        }

        .btn {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container mt-5">
    <div class=" list-group-item card-body p-4">
        <h2 class="mb-3 item-header">{{ $layanan->nama_layanan }}</h2>
    </div>

    <hr>
    <h4 class="item-header">Variasi Layanan</h4>

    @if($layanan->details->isEmpty())
        <p class="text-muted">Tidak ada variasi layanan.</p>
    @else
        <ul class="list-group">
            @foreach($layanan->details as $detail)
                <li class="list-group-item">
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div>
                            <p class="mb-1"><span class="detail-label">Tipe:</span> {{ $detail->nama_variasi }}</p>
                            <p class="mb-1"><span class="detail-label">Harga:</span> Rp {{ number_format($detail->harga_dasar) }}</p>
                            <p class="mb-2"><span class="detail-label">Deskripsi:</span> {{ $detail->deskripsi ?? '-' }}</p>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <a href="{{route('detail_layanan.edit', $detail->id)}}" class="btn btn-outline-custom btn-sm rounded-pill px-3">Edit</a>
                            <form action="{{route ('detail_layanan.destroy', $detail->id)}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus variasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-custom btn-sm rounded-pill px-3">Hapus</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('layanansaya') }}" class="btn btn-custom mt-4 rounded-pill px-4">Kembali</a>
</div>
@endsection
