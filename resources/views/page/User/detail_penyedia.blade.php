@extends('layout.main')

@section('content2')
@if (session('laporan_success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('laporan_success') }}',
                confirmButtonColor: '#bb9587',
            });
        });
    </script>
@endif

@php

    $buttonColor = $penyedia->color_button ?? '#bb9587';
    $isDark = isColorDark($buttonColor);
    $textColor = $isDark ? '#ffffff' : '#000000';
@endphp
<div class="py-4">
    <style>
        .scroll-container::-webkit-scrollbar { display: none; }
        .scroll-container {
            overflow-y: auto;
            max-height: 100%;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .thumbnail-wrapper.border-danger {
            border-width: 2px !important;
        }
        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .star-rating .star {
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
    </style>

    <!-- Galeri dan Informasi -->
    <div class="row flex-column flex-md-row mb-5">
        <!-- Galeri Foto -->
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="position-relative border rounded shadow-sm mb-2 bg-white" style="height: 450px; overflow: hidden;">
                <img id="mainImage"
                    src="{{ asset($penyedia->fotos->first()?->foto ?? 'img/placeholder.png') }}"
                    class="img-fluid w-100 h-100"
                    style="object-fit: cover;">
            </div>
            <div class="d-flex overflow-auto flex-nowrap gap-2">
                @foreach($penyedia->fotos as $index => $foto)
                    @if($foto->foto)
                    <div class="thumbnail-wrapper border {{ $index === 0 ? 'border-danger' : '' }}" style="cursor: pointer; flex: 0 0 auto;">
                        <img src="{{ asset($foto->foto) }}"
                            onclick="updateMainImage('{{ asset($foto->foto) }}', this)"
                            class="img-thumbnail"
                            style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Informasi dan Layanan -->

        <div class="col-md-7">
            <div class="p-4 rounded shadow-sm scroll-container h-100" style="background-color: {{ $penyedia->color_heading ?? '#bb9587' }};">

                <!-- Bagian Nama Toko dan Tombol Laporkan -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="mb-3 d-flex align-items-center">
                        <div class="me-3 mr-2" style="width: 48px; height: 48px; border-radius: 50%; background-color: #fff; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('img/logo.png') }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 class="fw-bold mb-0" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">{{ $penyedia->nama_toko }}</h3>
                    </div>

                    <!-- Tombol Report -->
                    <div class="d-flex justify-content-end">
                        <!-- Tombol Desktop -->
                        <a href="{{ route('laporan.create', $penyedia->id) }}"
                        class="d-none d-sm-inline-block btn btn-sm px-3 shadow-sm"
                        style="background-color: {{ $buttonColor }};
                                color: {{ $textColor }};
                                border: 1px solid {{ $textColor }};">
                            <i class="fas fa-flag fa-sm me-1" style="color: {{ $textColor }}"></i>
                            <span style="font-weight: 600;">Laporkan</span>
                        </a>

                        <!-- Tombol Mobile -->
                        <a href="{{ route('laporan.create', $penyedia->id) }}"
                        class="d-sm-none d-inline-block btn btn-sm px-3 shadow-sm d-flex align-items-center justify-content-center ms-2"
                        style="background-color: {{ $buttonColor }};
                                color: {{ $textColor }};
                                border: 1px solid {{ $textColor }};"
                        data-toggle="tooltip" data-placement="bottom" title="Laporkan penyedia">
                            <i class="fas fa-flag fa-sm me-1" style="color: {{ $textColor }}"></i>
                        </a>
                    </div>
                </div>

                <p class="mb-1" style="color: {{ $penyedia->color_font ?? '#000000' }};">
                    <i class="fas fa-map-marker-alt me-2"></i> {{ $penyedia->alamat_toko }}
                </p>

                <p style="color: {{ $penyedia->color_font ?? '#000000' }};"><strong>Rating:</strong> {{ number_format($penyedia->ulasan->avg('rating'), 1) }} / 5</p>

                <!-- Layanan -->
                <div class="mt-4">
                    <h5 class="fw-semibold mb-2" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">Layanan Tersedia</h5>
                     <p style="color: {{ $penyedia->color_font ?? '#000000' }};">Klik layanan untuk memesan</p>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse ($penyedia->layanans->where('status', 'tampilkan') as $layanan)
                            <a href="{{ route('pemesanan.create', $layanan->id) }}" class="text-decoration-none">
                                <div class="card shadow-sm m-1 border-0 px-3 py-2 text-center service-card">
                                    <span class="fw-semibold text-dark">{{ $layanan->nama_layanan }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="alert alert-warning text-center w-100">
                                <i class="fas fa-exclamation-circle me-2"></i> Penyedia ini belum memiliki layanan.
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="mt-4 p-3 bg-white rounded shadow-sm">
                    <h5 class="fw-semibold" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">Tentang Toko</h5>

                    {{-- Tampilan 2 baris --}}
                    <div id="deskripsiHidden" class="text-dark mt-2" style="line-height: 1.7; display: block; color: {{ $penyedia->color_font ?? '#000000' }}; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {!! nl2br(e($penyedia->deskripsi ?? 'Tidak ada deskripsi')) !!}
                    </div>

                    {{-- Tampilan full --}}
                    <div id="deskripsiShow" class="text-dark mt-2" style="line-height: 1.7; display: none; color: {{ $penyedia->color_font ?? '#000000' }};">
                        {!! nl2br(e($penyedia->deskripsi ?? 'Tidak ada deskripsi')) !!}
                    </div>

                    <button class="btn btn-sm btn-link px-0 mt-2" type="button" id="toggleDeskripsi">
                        <span id="toggleText">Lihat Selengkapnya</span>
                    </button>
                </div>



            </div>
        </div>
    </div>

    <!-- Form Ulasan -->
    <div class="my-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="mb-3" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">Beri Ulasan</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_penyedia" value="{{ $penyedia->id }}">
                    <div class="mb-3">
                        <label class="form-label d-block">Rating</label>
                        <div class="star-rating" style="font-size: 1.8rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-secondary star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                        @error('rating') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar (opsional)</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="3">{{ old('komentar') }}</textarea>
                        @error('komentar') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <button type="submit" class="btn text-white" style="background-color: {{ $penyedia->color_font_judul ?? '#000000' }};">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tampilkan Ulasan -->
    <div class="my-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="mb-3" style="color: #bb9587;">Ulasan Pengguna</h4>
                @php $ulasanTerbatas = $penyedia->ulasan->sortByDesc('created_at')->take(5); @endphp

                @if($ulasanTerbatas->isEmpty())
                    <p class="text-muted">Belum ada ulasan untuk penyedia ini.</p>
                @else
                    @foreach($ulasanTerbatas as $ulasan)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $ulasan->user->username }}</strong>
                                <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                            </div>
                            <div class="text-warning mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $ulasan->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            @if($ulasan->komentar)
                                <p class="mb-0 text-dark">{{ $ulasan->komentar }}</p>
                            @endif
                        </div>
                    @endforeach

                    @if($penyedia->ulasan->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('ulasan.show', $penyedia->id) }}" class="btn btn-sm btn-outline-secondary">
                                Lihat Semua Ulasan
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function updateMainImage(src, thumb) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail-wrapper').forEach(el => el.classList.remove('border-danger'));
        thumb.parentElement.classList.add('border-danger');
    }

    document.querySelectorAll('.star-rating .star').forEach(function(star) {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating').value = rating;

            document.querySelectorAll('.star-rating .star').forEach(function(s, index) {
                if (index < rating) {
                    s.classList.remove('text-secondary');
                    s.classList.add('text-warning');
                } else {
                    s.classList.remove('text-warning');
                    s.classList.add('text-secondary');
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleDeskripsi');
        const toggleText = document.getElementById('toggleText');
        const deskripsiShow = document.getElementById('deskripsiShow');
        const deskripsiHidden = document.getElementById('deskripsiHidden');

        let expanded = false;

        toggleBtn.addEventListener('click', function () {
            expanded = !expanded;

            if (expanded) {
                deskripsiShow.style.display = 'block';
                deskripsiHidden.style.display = 'none';
                toggleText.textContent = 'Sembunyikan';
            } else {
                deskripsiShow.style.display = 'none';
                deskripsiHidden.style.display = '-webkit-box';
                toggleText.textContent = 'Lihat Selengkapnya';
            }
        });
    });
</script>




@endsection
