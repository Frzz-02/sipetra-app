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

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4" style="color: #bb9587;">Laporkan Penyedia Layanan</h4>

            <p><strong>Penyedia:</strong> {{ $penyedia->nama_toko }}</p>
            <p><strong>Alamat:</strong> {{ $penyedia->alamat_toko }}</p>

            <form action="{{ route('laporan.store', $penyedia->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Laporan</label>
                    <textarea name="alasan" id="alasan" rows="5" class="form-control" placeholder="Tuliskan alasan Anda melaporkan penyedia ini..." required></textarea>
                    @error('alasan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn text-white" style="background-color: #bb9587;">Kirim Laporan</button>
                <a href="{{ route('penyedia_layanan.detail', $penyedia->id) }}" class="btn btn-secondary ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
