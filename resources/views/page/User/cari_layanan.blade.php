@extends('layout.main')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
">
    <style>
        .container::-webkit-scrollbar {
            display: none;
        }

        .text-bb9587 {
            color: #bb9587 !important;
        }

        .bg-bb9587 {
            background-color: #bb9587 !important;
        }

        .border-left-bb9587 {
            border-left: 4px solid #bb9587 !important;
        }

        .btn-bb9587 {
            background-color: #bb9587;
            color: #fff;
        }

        .btn-bb9587:hover {
            background-color: #a87d73;
        }
    </style>

    <h4 class="mb-4 font-weight-bold text-bb9587 text-center text-md-left">Cari Penyedia Layanan</h4>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('search.penyedia') }}" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="q" class="form-control border-bb9587" placeholder="Cari nama toko atau lokasi" value="{{ request('q') }}">
            <button class="btn btn-bb9587" type="submit">
                <i class="fas fa-search me-1"></i><span class="d-none d-sm-inline">Cari</span>
            </button>
        </div>
    </form>

    {{-- Daftar Penyedia --}}
<div class="row">
    @forelse($penyedia as $item)
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-left-bb9587 p-2" style="cursor: pointer;" onclick="window.location='{{ route('penyedia_layanan.detail', $item->id) }}'">

                <div class="d-flex">
                    {{-- Gambar Toko --}}
                    <div class="me-3" style="flex-shrink: 0;">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}"
                                 alt="Foto Toko {{ $item->nama_toko }}"
                                 class="rounded"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Informasi Toko --}}
                    <div class="flex-grow-1 ml-2">
                        <h5 class="card-title text-bb9587 mb-2 d-flex align-items-center">
                            <span class="text-truncate" style="max-width: 100%">{{ $item->nama_toko }} @if($item->ulasan && $item->ulasan->count())
                                    | {{ number_format($item->ulasan->avg('rating'), 1) }} / 5
                                @else
                                    | Belum ada rating
                                @endif
                            </span>
                        </h5>
                        <p class="card-text text-secondary mb-1">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $item->alamat_toko }}
                        </p>
                    </div>
                </div>
                <div class="my-2 scroll-hide">
                            @foreach ($item->layanans as $layanan)
                                <span class="badge bg-bb9587 text-white mb-1">{{ $layanan->nama_layanan }}</span>
                            @endforeach
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
