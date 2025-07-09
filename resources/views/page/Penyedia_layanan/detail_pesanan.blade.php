@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Detail Pesanan</h3>

    {{-- Informasi User Pemesan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Informasi Pemesan</h5>
            <div class="d-flex align-items-center mb-3 flex-wrap">
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="rounded-circle me-3 mb-2" width="60" height="60">
                <div style="min-width: 200px">
                    <p class="mb-0"><strong>{{ $user->username }}</strong></p>
                    <p class="mb-0">Email: {{ $user->email }}</p>
                    <p class="mb-0">Telepon: {{ $user->no_telephone }}</p>
                    <p class="mb-0">Alamat: {{ $user->alamat }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Hewan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Hewan yang Dipesan</h5>
            @forelse ($pesanan->details as $detail)
                <div class="border p-2 mb-3 rounded">
                    @if($detail->hewan)
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/hewan/' . $detail->hewan->foto_hewan) }}" alt="Hewan" class="me-3 rounded" width="80" height="80">
                        <div>
                            <p class="mb-0"><strong>{{ $detail->hewan->nama_hewan }}</strong> ({{ $detail->hewan->jenis_hewan }})</p>
                            <p class="mb-0">Umur: {{ $detail->hewan->umur ?? '-' }}</p>
                            <p class="mb-0">Berat: {{ $detail->hewan->berat ?? '-' }}</p>
                            <p class="mb-0">Jenis Kelamin: {{ ucfirst($detail->hewan->jenis_kelamin) }}</p>
                            <p class="mb-0">Tanggal Lahir: {{ $detail->hewan->tanggal_lahir }}</p>
                            <p class="mb-0">Deskripsi: {{ $detail->hewan->deskripsi ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                        <p class="mb-0 text-danger"><strong>Hewan tidak ditemukan</strong></p>
                    @endif
                </div>
            @empty
                <p>Tidak ada hewan.</p>
            @endforelse
        </div>
    </div>

    {{-- Detail Layanan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Detail Layanan</h5>
            <p><strong>Jenis Layanan:</strong> {{ ucfirst($tipe) }}</p>
            <p><strong>Harga per Item:</strong> Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @if ($tipe === 'penitipan')
                <p><strong>Tanggal Titip:</strong> {{ $pesanan->formatted_tanggal_titip }}</p>
                <p><strong>Tanggal Ambil:</strong> {{ $pesanan->formatted_tanggal_ambil }}</p>
                <p><strong>Lama Penitipan:</strong> {{ $jumlahHari }} hari</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jumlahHari }} hari x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @elseif ($tipe === 'antar jemput')
                <p><strong>Alamat Awal:</strong> {{ $alamatAwal }}</p>
                <p><strong>Alamat Tujuan:</strong> {{ $alamatTujuan }}</p>
                <p><strong>Estimasi Jarak:</strong> {{ $jarakKm }} km</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jarakKm }} km x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                <p>GeoJSON: {{ $ruteGeoJson ? 'Ada' : 'Kosong' }}</p>
                {{-- Peta --}}
                <div class="mt-4">
                    <div id="map" style="height: 300px; width: 100%; border-radius: 10px;"></div>
                </div>

            @elseif ($tipe === 'lokasi kandang')
                <p><strong>Tanggal Layanan:</strong> {{ $pesanan->formatted_tanggal_pesan }}</p>
                @if ($jumlahKandang)
                    <p><strong>Jumlah Kandang:</strong> {{ $jumlahKandang }}</p>
                    <p><strong>Perhitungan:</strong> {{ $jumlahKandang }} kandang x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                @elseif ($luasKandang)
                    <p><strong>Luas Kandang:</strong> {{ $luasKandang }} m<sup>2</sup></p>
                    <p><strong>Perhitungan:</strong> {{ $luasKandang }} m<sup>2</sup> x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                @else
                    <p><em>Data jumlah/luas kandang tidak tersedia.</em></p>
                @endif

            @else
                <p><strong>Tanggal Mulai:</strong> {{ $pesanan->formatted_tanggal_mulai }}</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
            @endif
        </div>
    </div>

    {{-- Rincian Pembayaran --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Rincian Biaya</h5>
            <p><strong>Subtotal Layanan:</strong> Rp{{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
            <p><strong>Biaya Penanganan:</strong> Rp{{ number_format($biayaPotongan, 0, ',', '.') }}</p>
            <hr>
            <p class="fw-bold text-primary">Total yang Harus Dibayar: Rp{{ number_format($biayaTotal, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

@if($tipe === 'antar jemput' && $lokasiAwal && $lokasiTujuan && $ruteGeoJson)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map', { zoomControl: false }).setView(
                [{{ $lokasiAwal['lat'] }}, {{ $lokasiAwal['lon'] }}],
                13
            );

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const start = [{{ $lokasiAwal['lat'] }}, {{ $lokasiAwal['lon'] }}];
            const end = [{{ $lokasiTujuan['lat'] }}, {{ $lokasiTujuan['lon'] }}];

            L.marker(start).addTo(map).bindPopup('Lokasi Awal').openPopup();
            L.marker(end).addTo(map).bindPopup('Lokasi Tujuan');

            const routeGeoJson = {!! json_encode($ruteGeoJson) !!};
            const routeLayer = L.geoJSON(routeGeoJson, {
                style: { color: 'blue', weight: 4 }
            }).addTo(map);

            // Zoom ke rute
            map.fitBounds(routeLayer.getBounds(), { padding: [30, 30] });
        });
    </script>
@endif

@endsection
