@extends('layout.main')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;      /* Firefox */
    -ms-overflow-style: none;   /* IE 10+ */
">
    <h3 class="mb-4 text-primary">Detail Transaksi</h3>

    {{-- Informasi Umum --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">Informasi Umum</h5>
            <p><strong>No. Pesanan:</strong> {{ $pesanan->id }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ date('d-m-Y H:i', strtotime($pesanan->tanggal_pesan)) }}</p>
            <p><strong>Status:</strong>
               <span class="badge {{
                    match($pesanan->status) {
                        'menunggu pembayaran' => 'bg-secondary',
                        'menunggu diproses' => 'bg-warning text-dark',
                        'diproses' => 'bg-info text-white',
                        'selesai' => 'bg-success text-white',
                        'batal' => 'bg-danger text-white',
                        default => 'bg-light text-dark'
                    }
                }}">
                    {{ ucfirst($pesanan->status) }}
                </span>
            </p>
            <p><strong>Subtotal Layanan:</strong> Rp{{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
            <p><strong>Biaya Penanganan:</strong> Rp{{ number_format($biayaPotongan, 0, ',', '.') }}</p>
            <hr>
            <p class="fw-bold text-primary"><strong>Total yang Harus Dibayar:</strong> Rp{{ number_format($biayaTotal, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Informasi Sedang Diproses --}}
    @if (in_array($pesanan->status, ['diproses', 'selesai']) && $sedangProses)
        <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3">Sedang Diproses</h5>

                @if ($sedangProses->petugas->count())
                    <p><strong>Petugas Penanganan:</strong></p>
                    <ul class="ps-3">
                        @foreach ($sedangProses->petugas->take(2) as $petugas)
                            <li>{{ $petugas->karyawan->nama ?? 'Nama tidak tersedia' }}</li>
                        @endforeach
                    </ul>
                @endif

                @if ($sedangProses->status_proses)
                    <p><strong>Status Proses Saat Ini:</strong> {{ $statusProsesTerakhir }}</p>
                @endif

                <a href="{{route('penyedia.proses.detail', $pesanan->id)}}" class="btn btn-outline-primary mt-3">
                    Lihat Detail Proses
                </a>
            </div>
        </div>
    @endif

    {{-- alasan pembatalan --}}
    @if ($pesanan->status === 'batal' && $pesanan->catatan_batal)
       <div class="card shadow border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title text-danger mb-3">
                    <i class="fas fa-times-circle me-2"></i>Catatan Pembatalan
                </h5>
                <p class="card-text mb-0">{{ $pesanan->catatan_batal }}</p>
            </div>
        </div>
    @endif




    {{-- Detail Layanan --}}
    <div class="card shadow border-0 mb-4">
     <div class="card-body">
            <h5 class="mb-3">Detail Layanan</h5>
            <p><strong>Nama Layanan:</strong> {{ optional($pesanan->details->first()?->layanan_detail)->nama_variasi ?? '-' }}</p>
            <p><strong>lokasi kandang:</strong> {{ $lokasiKandang }}</p>
            {{-- Tampilkan harga dan jumlah sesuai tipe --}}
            @if ($tipe === 'lokasi kandang')
                @if ($jumlahKandang)
                    <p><strong>Harga per Kandang:</strong> Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                    <p><strong>Jumlah Kandang:</strong> {{ $jumlahKandang }}</p>
                @elseif ($luasKandang)
                    <p><strong>Harga per m²:</strong> Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                    <p><strong>Luas Kandang:</strong> {{ $luasKandang }} m<sup>2</sup></p>
                @else
                    <p><strong>Harga:</strong> Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                    <p><em>Data jumlah/luas kandang tidak tersedia.</em></p>
                @endif
            @else
                <p><strong>Harga per Hewan:</strong> Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                <p><strong>Jumlah Hewan:</strong> {{ $jumlahHewan }}</p>
            @endif

            {{-- Detail berdasarkan tipe layanan --}}
            @if ($tipe === 'penitipan')
                <p><strong>Tanggal Titip:</strong> {{ date('d M Y', strtotime($tanggal_titip)) }}</p>
                <p><strong>Tanggal Ambil:</strong> {{ date('d M Y', strtotime($tanggal_ambil)) }}</p>
                <p><strong>Lama Penitipan:</strong> {{ $jumlah_hari }} hari</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jumlah_hari }} hari x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @elseif ($tipe === 'antar jemput')
                @if(isset($alamatAwal) && isset($alamatTujuan))
                    <p><strong>Alamat Awal:</strong><br> {{ $alamatAwal }}</p>
                    <p><strong>Alamat Tujuan:</strong><br> {{ $alamatTujuan }}</p>
                @endif
                <p><strong>Estimasi Jarak:</strong> {{ $total_jarak }} km</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $total_jarak }} km x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @elseif ($tipe === 'lokasi kandang')
                <p><strong>Tanggal Layanan:</strong> {{ date('d-m-Y', strtotime($pesanan->tanggal_pesan)) }}</p>
                <p><strong>lokasi kandang:</strong> {{ $lokasiKandang}}</p>
                @if ($jumlahKandang)
                    <p><strong>Perhitungan:</strong> {{ $jumlahKandang }} kandang x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                @elseif ($luasKandang)
                    <p><strong>Perhitungan:</strong> {{ $luasKandang }} m<sup>2</sup> x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
                @endif

            @else
                <p><strong>Tanggal Layanan:</strong> {{ date('d-m-Y', strtotime($pesanan->tanggal_mulai)) }}</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>
            @endif
        </div>
    </div>

    {{-- Daftar Hewan --}}
    <div class="card shadow border-0">
        <div class="card-body">
            <h5 class="mb-3">Daftar Hewan</h5>
            <ul class="list-group list-group-flush">
                @foreach ($pesanan->details as $detail)
                    <li class="list-group-item">
                        {{ $detail->hewan->nama_hewan ?? 'Hewan tidak ditemukan' }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('riwayat.pesanan') }}" class="btn btn-secondary mt-4">Kembali ke Riwayat</a>
        {{-- Tombol Batalkan --}}
    @if ($pesanan->status === 'menunggu pembayaran')
        <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger mt-4 ms-2" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                Batalkan Pesanan
            </button>
        </form>

    @elseif ($pesanan->status === 'menunggu diproses')
        <!-- Trigger Modal -->
        <button class="btn btn-danger mt-4 ms-2" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiBatal">
            Batalkan Pesanan
        </button>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="modalKonfirmasiBatal" tabindex="-1" aria-labelledby="modalKonfirmasiBatalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalKonfirmasiBatalLabel">Pembatalan Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p>
                Pembayaran berhasil dibatalkan. Dana akan dikembalikan ke metode pembayaran Anda dalam waktu maksimal <strong>1 x 24 jam</strong> sesuai kebijakan platform.
                </p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
        </div>
    @endif

</div>
@endsection
