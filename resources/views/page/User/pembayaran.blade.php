@extends('layout.auth')

@section('content')
<div class="container mt-4">
    <h3>Pembayaran Layanan</h3>

    <p><strong>Layanan:</strong> {{ $layanan->nama_layanan }}</p>
    <p><strong>Deskripsi:</strong> {{ $layanan->deskripsi }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($pesanan->total_biaya) }}</p>

    {{-- Tampilkan daftar hewan --}}
    <h5>Hewan yang Dipesan:</h5>
    <ul>
        @foreach ($pesanan->details as $detail)
            <li>{{ $detail->hewan->nama_hewan }} - {{ $detail->hewan->jenis_hewan }}</li>
        @endforeach
    </ul>

    {{-- Form Pembayaran Biasa --}}
    <form action="{{ route('pembayaran.proses') }}" method="POST" enctype="multipart/form-data" id="form-pembayaran">
        @csrf
        <input type="hidden" name="id_pesanan" value="{{ $pesanan->id }}">

        @if(Str::contains(strtolower($layanan->nama_layanan), 'antar jemput'))
            <div class="mb-3">
                <label>Lokasi Awal</label>
                <input type="text" name="lokasi_awal" class="form-control">
            </div>
            <div class="mb-3">
                <label>Lokasi Tujuan</label>
                <input type="text" name="lokasi_tujuan" class="form-control">
            </div>
        @elseif(Str::contains(strtolower($layanan->nama_layanan), 'pembersihan kandang'))
            <div class="mb-3">
                <label>Lokasi Kandang</label>
                <input type="text" name="lokasi_kandang" class="form-control">
            </div>
        @else
            <div class="mb-3">
                <label>Detail Layanan</label>
                <textarea class="form-control" readonly>{{ $layanan->deskripsi }}</textarea>
            </div>
        @endif

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" id="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="transfer">Transfer Bank</option>
                <option value="cod">Bayar di Tempat</option>
                <option value="midtrans">Bayar via Midtrans</option>
            </select>
        </div>

        <div class="mb-3" id="bukti_bayar_field">
            <label>Bukti Pembayaran (opsional)</label>
            <input type="file" name="bukti_bayar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" id="submit-button">Kirim Pembayaran</button>

        {{-- Tombol Bayar via Midtrans --}}
        <button type="button" class="btn btn-success" id="midtrans-button" style="display: none;">
            Bayar via Midtrans
        </button>
    </form>
</div>

{{-- Script Snap.js --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metodeSelect = document.getElementById('metode_pembayaran');
        const midtransBtn = document.getElementById('midtrans-button');
        const submitBtn = document.getElementById('submit-button');
        const buktiField = document.getElementById('bukti_bayar_field');

        metodeSelect.addEventListener('change', function () {
            if (this.value === 'midtrans') {
                midtransBtn.style.display = 'inline-block';
                submitBtn.style.display = 'none';
                buktiField.style.display = 'none';
            } else {
                midtransBtn.style.display = 'none';
                submitBtn.style.display = 'inline-block';
                buktiField.style.display = 'block';
            }
        });

        midtransBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fetch("{{ route('midtrans.bayar', ['id_pesanan' => $pesanan->id]) }}")
                .then(res => res.json())
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            alert("Pembayaran berhasil!");
                            window.location.href = "/dashboard";
                        },
                        onPending: function(result){
                            alert("Menunggu pembayaran...");
                            window.location.href = "/dashboard";
                        },
                        onError: function(result){
                            alert("Pembayaran gagal!");
                            console.log(result);
                        },
                        onClose: function(){
                            alert("Transaksi dibatalkan.");
                        }
                    });
                })
                .catch(err => {
                    alert("Gagal mendapatkan Snap Token");
                    console.error(err);
                });
        });
    });
</script>
@endsection
