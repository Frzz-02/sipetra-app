@extends('layout.main')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;      /* Firefox */
    -ms-overflow-style: none;   /* IE 10+ */
">
    <style>
        .container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
    <!-- Header Toko -->
   <div class="mb-5 p-4 rounded shadow-sm d-flex flex-column flex-md-row align-items-start" style="background-color: #f9f5f3;">
    <!-- Gambar Toko -->
       <div class="mb-3 mb-md-0 me-md-4 border rounded mr-2" style="flex-shrink: 0; width: 200px; height: 150px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0;">
            @if($penyedia->foto)
                <img src="{{ asset('storage/' . $penyedia->foto) }}"
                    alt="Foto Toko {{ $penyedia->nama_toko }}"
                    class="rounded"
                    style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <span class="text-muted">Foto belum tersedia</span>
            @endif
        </div>


        <!-- Info Toko -->
        <div>
            <h2 class="fw-bold mb-2" style="color: #bb9587;">
                <i class="fas fa-store me-2"></i>{{ $penyedia->nama_toko }}
            </h2>
            <p class="text-muted mb-1">
                <i class="fas fa-map-marker-alt me-2"></i> {{ $penyedia->alamat_toko }}
            </p>
            <p><strong>Rating:</strong> {{ number_format($penyedia->ulasan->avg('rating'), 1) }} / 5</p>
            @if($penyedia->deskripsi)
            <p class="mt-3 text-dark" style="line-height: 1.7;">
                <i class="fas fa-info-circle me-2 text-secondary"></i>{{ $penyedia->deskripsi }}
            </p>
            @endif
        </div>
    </div>

    <!-- Judul Layanan -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="fw-semibold" style="color: #bb9587;">Layanan Tersedia</h4>
        <hr class="flex-grow-1 ms-3" style="border-top: 2px solid #bb9587; max-width: 150px;">
    </div>

    <!-- Daftar Layanan -->
    <div class="row">
        @forelse($penyedia->layanans as $layanan)
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 service-card" style="transition: 0.3s;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title fw-bold" style="color: #333;">
                        <i class="fas fa-paw me-2 text-warning"></i>{{ $layanan->nama_layanan }}
                    </h5>
                    <p class="text-muted small mt-2">Klik untuk pesan layanan</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('pemesanan.create', $layanan->id) }}" class="btn btn-sm" style="background-color: #bb9587; color: white;">
                        Pesan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-circle me-2"></i> Penyedia ini belum memiliki layanan.
            </div>
        </div>
        @endforelse
    </div>
   <!-- Form Ulasan -->
<div class=" my-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="mb-3" style="color: #bb9587;">Beri Ulasan</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('ulasan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_penyedia" value="{{ $penyedia->id }}">

                <!-- Rating bintang -->
                <div class="mb-3">
                    <label class="form-label d-block">Rating</label>
                    <div class="star-rating" style="font-size: 1.8rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-secondary star" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" required>
                    @error('rating')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Komentar -->
                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar (opsional)</label>
                    <textarea name="komentar" id="komentar" class="form-control" rows="3" placeholder="Tulis komentar...">{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn text-white" style="background-color: #bb9587;">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</div>

<!-- Tampilkan Ulasan -->
<div class="my-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="mb-3" style="color: #bb9587;">Ulasan Pengguna</h4>

            @php
                $ulasanTerbatas = $penyedia->ulasan->sortByDesc('created_at')->take(5);
            @endphp

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

<script>
    document.querySelectorAll('.star-rating .star').forEach(function(star) {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating').value = rating;

            // Update warna bintang
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
@endsection

@push('styles')
<style>
    .service-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
     .star-rating .star {
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }
</style>
@endpush
