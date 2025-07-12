@extends('layout.layout_penyedia')

@section('content2')
<style>
    .layanan-container {
        max-height: calc(100vh - 100px);
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .layanan-container::-webkit-scrollbar {
        display: none;
    }

    .btn-custom {
        background-color: #bb9587;
        border: none;
        color: white;
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

    .card-layanan {
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-layanan:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        color: #bb9587;
        font-weight: bold;
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1.1rem;
        }

        .card-text {
            font-size: 0.9rem;
        }
    }
</style>

<div class="layanan-container py-4 px-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <h2 class="mb-0" style="color:#bb9587;">Karyawan</h2>
        <a href="{{ route('karyawan.create') }}" class="btn btn-custom px-4 py-2 rounded-pill shadow-sm">+ Tambah Karyawan</a>
    </div>
    @if($karyawan->isEmpty())
        <div class="alert alert-info text-center" style="background-color: #f6e8e4; color: #7a5f56;">
            Anda belum memiliki layanan. Silakan tambahkan layanan terlebih dahulu.
        </div>
    @else
        <div class="row">
            @foreach($karyawan as $layanan)
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card card-layanan h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $layanan->nama }}</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('layanan.detaillayanan', $layanan->id) }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">Lihat Detail</a>
                                <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-custom btn-sm rounded-pill px-3">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
