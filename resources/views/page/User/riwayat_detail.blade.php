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
                <span class="badge bg-{{
                    match($pesanan->status) {
                        'menunggu pembayaran' => 'secondary',
                        'menunggu diproses' => 'warning text-dark',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'batal' => 'danger',
                        default => 'light text-dark'
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

    {{-- Detail Layanan --}}
    <div class="card shadow border-0 mb-4">
     <div class="card-body">
            <h5 class="mb-3">Detail Layanan</h5>

            <p><strong>Jenis Layanan:</strong> {{ ucfirst($tipe) }}</p>

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
                <p><strong>Tanggal Titip:</strong> {{ date('d-m-Y', strtotime($pesanan->tanggal_titip)) }}</p>
                <p><strong>Tanggal Ambil:</strong> {{ date('d-m-Y', strtotime($pesanan->tanggal_ambil)) }}</p>
                <p><strong>Lama Penitipan:</strong> {{ $jumlahHari }} hari</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jumlahHari }} hari x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @elseif ($tipe === 'antar jemput')
                @if(isset($alamatAwal) && isset($alamatTujuan))
                    <p><strong>Alamat Awal:</strong><br> {{ $alamatAwal }}</p>
                    <p><strong>Alamat Tujuan:</strong><br> {{ $alamatTujuan }}</p>
                @endif
                <p><strong>Estimasi Jarak:</strong> {{ $jarakKm }} km</p>
                <p><strong>Perhitungan:</strong> {{ $jumlahHewan }} hewan x {{ $jarakKm }} km x Rp{{ number_format($hargaPerItem, 0, ',', '.') }}</p>

            @elseif ($tipe === 'lokasi kandang')
                <p><strong>Tanggal Layanan:</strong> {{ date('d-m-Y', strtotime($pesanan->tanggal_pesan)) }}</p>
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
</div>
@endsection
