@extends('layout.auth')

@section('content')
<div class="container">
    <h3>Form Pemesanan Layanan</h3>

    <form action="{{ route('pemesanan.store') }}" method="POST">
        @csrf

        <!-- Pilih Variasi Layanan -->
        <div class="mb-3">
            <label class="form-label">Pilih Tipe/Variasi Layanan</label><br>
                @foreach ($layananDetails as $index => $detail)
                    <div class="form-check">
                        <input
                            type="radio"
                            name="id_variasi"
                            id="variasi{{ $detail->id }}"
                            value="{{ $detail->id }}"
                            class="form-check-input tipe-input-radio"
                            data-tipe="{{ strtolower($detail->layanan->tipe_input) }}"
                            {{ $index === 0 ? 'checked' : '' }} {{-- << Tambahkan ini --}}
                            required>
                        <label for="variasi{{ $detail->id }}" class="form-check-label">
                            {{ $detail->layanan->nama_layanan }} - {{ $detail->tipe }}
                            (Rp{{ number_format($detail->harga_dasar, 0) }})
                        </label>
                    </div>
                @endforeach
        </div>

        <!-- Pilih Hewan -->
        <div class="mb-3">
            <label class="form-label">Pilih Hewan Anda</label><br>
            @foreach ($hewans as $hewan)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="id_hewan[]"
                        value="{{ $hewan->id }}"
                        id="hewan{{ $hewan->id }}"
                        required>
                    <label class="form-check-label" for="hewan{{ $hewan->id }}">
                        {{ $hewan->nama }} ({{ $hewan->jenis }})
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Tanggal Titip & Ambil -->
        <div class="mb-3 tipe-penitipan d-none">
            <label for="tanggal_titip" class="form-label">Tanggal Titip</label>
            <input type="datetime-local" name="tanggal_titip" id="tanggal_titip" class="form-control">
        </div>
        <div class="mb-3 tipe-penitipan d-none">
            <label for="tanggal_ambil" class="form-label">Tanggal Ambil</label>
            <input type="datetime-local" name="tanggal_ambil" id="tanggal_ambil" class="form-control">
        </div>

        <!-- Lokasi Antar Jemput -->
        <div class="mb-3 tipe-antar-jemput d-none">
            <label for="lokasi_awal" class="form-label">Lokasi Awal</label>
            <input type="text" name="lokasi_awal" id="lokasi_awal" class="form-control">
        </div>
        <div class="mb-3 tipe-antar-jemput d-none">
            <label for="lokasi_tujuan" class="form-label">Lokasi Tujuan</label>
            <input type="text" name="lokasi_tujuan" id="lokasi_tujuan" class="form-control">
        </div>

        <!-- Tanggal Pesan -->
        <div class="mb-3 tipe-lainnya d-none">
            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
            <input type="datetime-local" name="tanggal_pesan" id="tanggal_pesan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
    </form>
</div>

<script>
        const radios = document.querySelectorAll('.tipe-input-radio');

        function handleTipe(tipe) {
            document.querySelectorAll('.tipe-penitipan, .tipe-antar-jemput, .tipe-lainnya').forEach(el => {
                el.classList.add('d-none');
            });

            if (tipe === 'penitipan') {
                document.querySelectorAll('.tipe-penitipan').forEach(el => el.classList.remove('d-none'));
            } else if (tipe === 'antar jemput') {
                document.querySelectorAll('.tipe-antar-jemput').forEach(el => el.classList.remove('d-none'));
            } else {
                document.querySelectorAll('.tipe-lainnya').forEach(el => el.classList.remove('d-none'));
            }
        }

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                handleTipe(this.dataset.tipe);
            });

            // Cek saat halaman pertama kali dimuat
            if (radio.checked) {
                handleTipe(radio.dataset.tipe);
            }
        });
</script>

@endsection


