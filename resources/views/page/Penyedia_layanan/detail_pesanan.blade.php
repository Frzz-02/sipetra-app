@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
">
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
            <div class="overflow-auto" style="max-height: 400px;">
                @forelse ($pesanan->details as $detail)
                    <div class="border p-2 mb-3 rounded">
                        @if($detail->hewan)
                        <div class="d-flex align-items-start flex-wrap flex-md-nowrap">
                            <img src="{{ asset('assets/hewan/' . $detail->hewan->foto_hewan) }}" alt="Hewan" class="me-3 mb-2 rounded" width="80" height="80" loading="lazy">
                            <div style="min-width: 200px">
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
                <p><strong>Lama Penitipan:</strong> {{ $jumlah_hari }} hari</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jumlah_hari }} hari x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

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
    {{-- Informasi Penugasan --}}
    @if(isset($sedangProses))
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3 text-success">Informasi Penugasan</h5>

            <p><strong>Catatan Penugasan:</strong> {{ $sedangProses->catatan ?? '-' }}</p>

            {{-- Petugas yang Menangani --}}
            <h6 class="mt-3">Petugas yang Menangani:</h6>
            @forelse ($sedangProses->petugas as $petugas)
                <p class="mb-1">- {{ $petugas->karyawan->nama ?? 'Tidak ditemukan' }}</p>
            @empty
                <p class="text-muted">Belum ada petugas ditugaskan.</p>
            @endforelse

            {{-- Riwayat Status Proses --}}
            <h6 class="mt-3">Riwayat Status Proses:</h6>
            @forelse ($sedangProses->status_proses as $status)
                <p class="mb-1">
                    • <strong>{{ ucfirst($status->status) }}</strong>
                    <span class="text-muted">({{ \Carbon\Carbon::parse($status->waktu)->translatedFormat('d M Y H:i') }})</span>
                </p>
            @empty
                <p class="text-muted">Belum ada status proses.</p>
            @endforelse
            <!-- Tombol Tambah Riwayat -->
           @if($pesanan->status !== 'selesai')
                <div class="mt-2">
                    <a href="{{ route('status.tambah.form', $sedangProses->id) }}" class="btn btn-sm btn-outline-primary">
                        + Tambah Riwayat Status
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif


    {{-- Rincian Pembayaran --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Rincian Biaya</h5>
            <p><strong>Subtotal Layanan:</strong> Rp{{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
            <hr>
            <p class="fw-bold text-primary">Total yang Harus Dibayar: Rp{{ number_format($biayaTotal, 0, ',', '.') }}</p>
        </div>
    </div>
    {{-- Tombol Aksi --}}
  <div class="position-sticky bottom-0 bg-white py-3 px-3 shadow-lg d-flex flex-column flex-md-row justify-content-between align-items-center gap-2" style="z-index: 1000;">
        <a href="{{route('penyedia.dashboard')}}" class="btn btn-outline-secondary w-100 w-md-auto">← Kembali</a>

        @if($pesanan->status !== 'selesai')
        <div class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
            @if($pesanan->status === 'diproses')
                <form action="{{ route('pesanan.selesai', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 w-md-auto">
                        Selesaikan Pesanan
                    </button>
                </form>
            @else
                <form action="{{ route('pesanan.proses', $pesanan->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 w-md-auto" style="background-color: #003366; border-color: #003366;">
                        Proses Pesanan
                    </button>
                </form>
            @endif

            <button type="button" class="btn btn-danger w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#modalBatal">
                Batalkan Pesanan
            </button>
        </div>
        @endif
    </div>

    <!-- Modal Pembatalan -->
    <div class="modal fade" id="modalBatal" tabindex="-1" aria-labelledby="modalBatalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pesanan.batalkan', $pesanan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalBatalLabel">Batalkan Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan_batal" class="form-label">Alasan Pembatalan</label>
                        <textarea name="catatan_batal" id="catatan_batal" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                </div>
            </div>
        </form>
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

            map.fitBounds(routeLayer.getBounds(), { padding: [30, 30] });
        });
    </script>
@endif
@endsection
