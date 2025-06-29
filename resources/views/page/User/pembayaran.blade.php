@extends('layout.main')

@section('content2')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <h3 class="mb-4 text-primary">Pembayaran Layanan</h3>

            <div class="mb-3">
                <strong>Layanan:</strong> {{ $layanan->nama_layanan }}<br>
                <strong>Deskripsi:</strong> {{ $layanan->deskripsi }}<br>
                <strong>Total:</strong> Rp {{ number_format($pesanan->total_biaya) }}
            </div>

            <div class="mb-3">
                <h5 class="text-secondary">Hewan yang Dipesan:</h5>
                <ul class="list-group">
                    @foreach ($pesanan->details as $detail)
                        <li class="list-group-item">
                            {{ $detail->hewan->nama_hewan }} - {{ $detail->hewan->jenis_hewan }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <form id="form-pembayaran">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id }}">

                @if(Str::contains(strtolower($layanan->nama_layanan), 'antar jemput'))
                    <div class="mb-3">
                        <label class="form-label">Lokasi Awal</label>
                        <input type="text" name="lokasi_awal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Tujuan</label>
                        <input type="text" name="lokasi_tujuan" class="form-control" required>
                    </div>
                @elseif(Str::contains(strtolower($layanan->nama_layanan), 'pembersihan kandang'))
                    <div class="mb-3">
                        <label class="form-label">Lokasi Kandang</label>
                        <input type="text" name="lokasi_kandang" class="form-control" required>
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">Detail Layanan</label>
                        <textarea class="form-control" readonly>{{ $layanan->deskripsi }}</textarea>
                    </div>
                @endif

                <div class="d-grid">
                    <button type="button" class="btn btn-success" id="midtrans-button">
                        Bayar Sekarang via Midtrans
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const midtransBtn = document.getElementById('midtrans-button');

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
