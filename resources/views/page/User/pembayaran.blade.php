@extends('layout.auth')

@section('content')
<div class="container">
    <h3>Pembayaran Layanan</h3>
    <p><strong>Layanan:</strong> {{ $layanan->nama_layanan }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($pesanan->total_biaya) }}</p>

    <form action="{{ route('pembayaran.proses') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_pesanan" value="{{ $pesanan->id }}">

        @if(Str::contains(strtolower($layanan->nama_layanan), 'antar jemput'))
            <div class="mb-3">
                <label>Lokasi Awal</label>
                <input type="text" name="lokasi_awal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Lokasi Tujuan</label>
                <input type="text" name="lokasi_tujuan" class="form-control" required>
            </div>
        @elseif(Str::contains(strtolower($layanan->nama_layanan), 'pembersihan kandang'))
            <div class="mb-3">
                <label>Lokasi Kandang</label>
                <input type="text" name="lokasi_kandang" class="form-control" required>
            </div>
        @else
            <div class="mb-3">
                <label>Detail Layanan</label>
                <textarea class="form-control" readonly>{{ $layanan->deskripsi }}</textarea>
            </div>
        @endif

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="transfer">Transfer Bank</option>
                <option value="cod">Bayar di Tempat</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bukti Pembayaran (opsional)</label>
            <input type="file" name="bukti_bayar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
    </form>
</div>
@endsection
