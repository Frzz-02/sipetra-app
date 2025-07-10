@extends('layout.main')

@section('content2')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class=" py-4" style="
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

    <h3 class="mb-4 fw-bold" style="color:#bb9587;">Form Pemesanan Layanan</h3>

    <form action="{{ route('pemesanan.store', ['id_layanan' => $layanan->id]) }}" method="POST">
        @csrf

        <!-- Pilih Variasi Layanan -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Pilih Tipe/Variasi Layanan</label>
            <div class="row">
                @foreach ($layananDetails as $index => $detail)
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <input
                        type="radio"
                        name="id_variasi"
                        id="variasi{{ $detail->id }}"
                        value="{{ $detail->id }}"
                        class="d-none variasi-checkbox"
                         data-tipe="{{ strtolower($detail->layanan->tipe_input) }}"
                         {{ $index === 0 ? 'checked' : '' }}>
                    <label for="variasi{{ $detail->id }}" class="card h-100 shadow-sm hewan-card p-3 text-start">
                        <div>
                            <strong>{{ $detail->nama_variasi }}</strong><br>
                            <small class="text-muted">{{ $detail->deskripsi }}</small><br>
                            <span class="text-primary">Rp{{ number_format($detail->harga_dasar, 0) }}</span>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pilih Hewan -->
        <div class="mb-4 pilih-hewan">
            <label class="form-label fw-semibold">Pilih Hewan Anda</label>
            <div class="row">
                @foreach ($hewans as $hewan)
                <div class="col-6 col-sm-6 col-md-4 mb-3">
                    <input type="checkbox" name="id_hewan[]" id="hewan{{ $hewan->id }}" value="{{ $hewan->id }}" class="d-none hewan-checkbox">
                    <label for="hewan{{ $hewan->id }}" class="card h-100 shadow-sm hewan-card p-3 text-start">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/hewan/' . $hewan->foto_hewan) }}"
                                alt="{{ $hewan->foto_hewan }}"
                                class="rounded-circle me-3 border border-dark mr-2"
                                style="width: 48px; height: 48px; object-fit: cover;">
                            <div>
                                <strong>{{ $hewan->nama_hewan }}</strong><br>
                                <small class="text-muted">{{ $hewan->jenis_hewan }}</small>
                            </div>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
             <a href="{{ route('add_hewan', ['redirect' => url()->current()]) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah hewan
            </a>
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
            <label>Lokasi Awal</label>
            <input type="text" name="lokasi_awal" id="lokasi_awal" class="form-control mb-2" readonly>
            <div id="map_awal" style="height: 200px;"></div>
        </div>

        <div class="mb-3 tipe-antar-jemput d-none">
            <label>Lokasi Tujuan</label>
            <input type="text" name="lokasi_tujuan" id="lokasi_tujuan" class="form-control mb-2" readonly>
            <div id="map_tujuan" style="height: 200px;"></div>
        </div>

        <!-- pembersihan kandang -->
        <div class="mb-3 pembersihan_kandang d-none">
            <label>Jumlah Kandang</label>
            <input type="text" name="jumlah_kandang" id="jumlah_kandang" class="form-control mb-2" >
        </div>

        <div class="mb-3 pembersihan_kandang d-none">
            <label>Luas kandang</label>
            <input type="text" name="luas_kandang" id="luas_kandang" class="form-control mb-2" >
        </div>

        <div class="mb-3 pembersihan_kandang d-none">
            <label>Lokasi kandang</label>
            <input type="text" name="lokasi_kandang" id="lokasi_kandang" class="form-control mb-2">
        </div>

        <div class="mb-3 pembersihan_kandang d-none">
            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
            <input type="datetime-local" name="tanggal_pesan" id="tanggal_pesan" class="form-control">
        </div>

        <!-- Tanggal Pesan -->
        <div class="mb-3 tipe-lainnya d-none">
            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
            <input type="datetime-local" name="tanggal_pesan" id="tanggal_pesan" class="form-control">
        </div>
         <div class="mb-3 tipe-lainnya d-none">
            <label>Lokasi kandang(opsional)</label>
            <input type="text" name="lokasi_kandang" id="lokasi_kandang" class="form-control mb-2" >
        </div>

        <button type="submit" class="btn" style="background-color:#bb9587; color:white;">
            <i class="fas fa-paper-plane me-1"></i> Pesan Sekarang
        </button>
    </form>
</div>

{{-- Script Pilihan Variasi --}}
<script>
    const checkboxes = document.querySelectorAll('.variasi-checkbox');

    function handleTipe(tipe) {
        document.querySelectorAll('.tipe-penitipan, .tipe-antar-jemput, .tipe-lainnya, .pembersihan_kandang').forEach(el => {
            el.classList.add('d-none');
        });

        if (tipe === 'penitipan') {
            document.querySelectorAll('.tipe-penitipan').forEach(el => el.classList.remove('d-none'));
        } else if (tipe === 'antar jemput') {
            document.querySelectorAll('.tipe-antar-jemput').forEach(el => el.classList.remove('d-none'));
        } else if (tipe === 'lokasi kandang') {
            document.querySelectorAll('.pembersihan_kandang').forEach(el => el.classList.remove('d-none'));
            if (tipe === 'lokasi kandang') {
                document.querySelector('.pilih-hewan')?.classList.add('d-none');
            } else {
                document.querySelector('.pilih-hewan')?.classList.remove('d-none');
            }
        } else {
            document.querySelectorAll('.tipe-lainnya').forEach(el => el.classList.remove('d-none'));
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                handleTipe(this.dataset.tipe);
            }
        });

        if (checkbox.checked) {
            handleTipe(checkbox.dataset.tipe);
        }
    });
</script>

{{-- Script Maps --}}
<script>
    const mapAwal = L.map('map_awal').setView([-7.797068, 110.370529], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapAwal);

    let markerAwal;
    mapAwal.on('click', function(e) {
        if (markerAwal) mapAwal.removeLayer(markerAwal);
        markerAwal = L.marker(e.latlng).addTo(mapAwal);
        document.getElementById('lokasi_awal').value = e.latlng.lat + ',' + e.latlng.lng;
    });

    const mapTujuan = L.map('map_tujuan').setView([-7.797068, 110.370529], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapTujuan);

    let markerTujuan;
    mapTujuan.on('click', function(e) {
        if (markerTujuan) mapTujuan.removeLayer(markerTujuan);
        markerTujuan = L.marker(e.latlng).addTo(mapTujuan);
        document.getElementById('lokasi_tujuan').value = e.latlng.lat + ',' + e.latlng.lng;
    });
</script>
<script>
    const inputTitip = document.getElementById('tanggal_titip');
    const inputAmbil = document.getElementById('tanggal_ambil');

    function validateTanggalAmbil() {
        const titip = new Date(inputTitip.value);
        const ambil = new Date(inputAmbil.value);

        if (ambil < titip) {
            inputAmbil.setCustomValidity("Tanggal ambil tidak boleh lebih awal dari tanggal titip.");
        } else {
            inputAmbil.setCustomValidity("");
        }
    }

    inputTitip.addEventListener('change', validateTanggalAmbil);
    inputAmbil.addEventListener('change', validateTanggalAmbil);
</script>

{{-- Style tambahan --}}
@push('styles')
<style>
    .hewan-card:hover {
        background-color: #f7f1ef;
        border-color: #bb9587;
    }
</style>
<style>
    .hewan-card {
        cursor: pointer;
        transition: border 0.3s, background-color 0.3s;
        border: 2px solid transparent;
    }

    .hewan-checkbox:checked + .hewan-card,
    .variasi-checkbox:checked + .hewan-card {
        border-color: #bb9587;
        background-color: #fef5f3;
    }
</style>
@endpush

@endsection
