@extends('layout.main')

@section(
    "content2"
)

<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
">
    {{-- <style>
        .container::-webkit-scrollbar {
            display: none;
        }

        .text-bb9587 {
            color: #bb9587 !important;
        }

        .bg-bb9587 {
            background-color: #bb9587 !important;
        }


        .btn-bb9587 {
            background-color: #bb9587;
            color: #fff;
        }

        .btn-bb9587:hover {
            background-color: #a87d73;
        }
    </style> --}}

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
            <div class="card h-100 shadow-sm  p-2" style="cursor: pointer; border-left: 4px solid {{ $item->color_button ?? '#bb9587' }}  " onclick="window.location='{{ route('penyedia_layanan.detail', $item->id) }}'">

                <div class="d-flex">
                    {{-- Gambar Toko --}}
                    <div class="me-3" style="flex-shrink: 0;">
                         @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}"
                                alt="Foto Toko {{ $item->nama_toko }}"
                                class="rounded"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @elseif($item->fotos->first())
                            <img src="{{ asset($item->fotos->first()->foto) }}"
                                alt="Foto Toko {{ $item->nama_toko }}"
                                class="rounded"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/image/placeholder.png') }}"
                                alt="Tidak ada foto"
                                class="rounded"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @endif

                    </div>

                    {{-- Informasi Toko --}}
                    <div class="flex-grow-1 ml-2">
                        <h5 class=" mb-2 d-flex align-items-center" style="max-width: 100%; color: {{ $item->color_button ?? '#bb9587' }};">
                           <span style="max-width: 100%; color: {{ $item->color_button ?? '#bb9587' }};">
                                {{ $item->nama_toko }}
                                @if($item->ulasan && $item->ulasan->count())
                                    | {{ number_format($item->ulasan->avg('rating'), 1) }} / 5
                                @else
                                    | 0.0 / 5
                                @endif
                            </span>
                        </h5>
                       <span class=" mb-1" style="color: {{ $item->color_font ?? '#000000' }};">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $item->alamat_toko }}
                       </span>

                    </div>
                </div>
                <div class="my-2 scroll-hide">
                    @php
                        function isColorDark($hexColor) {
                            $hexColor = ltrim($hexColor, '#');
                            $r = hexdec(substr($hexColor, 0, 2));
                            $g = hexdec(substr($hexColor, 2, 2));
                            $b = hexdec(substr($hexColor, 4, 2));
                            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
                            return $brightness < 128;
                        }

                        $bgColor = $item->color_button ?? '#bb9587';
                        $textColor = isColorDark($bgColor) ? '#ffffff' : '#000000';
                    @endphp
                    @foreach ($item->layanans->where('status', 'tampilkan') as $layanan)
                        <span class="badge mb-1" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            {{ $layanan->nama_layanan }}
                        </span>
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