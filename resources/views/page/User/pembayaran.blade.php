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
                .then(async res => {
                    if (!res.ok) {
                        const text = await res.text();
                        console.error("Error Response:", text);
                        alert("Gagal mendapatkan Snap Token: " + res.status);
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data && data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");

                                // Kirim ke backend untuk update status
                                fetch("/pesanan/update-status/" + {{ $pesanan->id }}, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    }
                                })
                                .then(res => res.json())
                                .then(response => {
                                    console.log(response.message);
                                    window.location.href = "/dashboard";
                                })
                                .catch(error => {
                                    console.error("Gagal update status:", error);
                                    window.location.href = "/dashboard";
                                });
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran...");
                                window.location.href = "/dashboard";
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                console.error(result);
                            },
                            onClose: function() {
                                alert("Transaksi dibatalkan.");
                            }
                        });
                    } else {
                        console.error("Respon tidak sesuai:", data);
                        alert("Gagal mendapatkan Snap Token (token tidak tersedia).");
                    }
                })
                .catch(err => {
                    alert("Gagal mendapatkan Snap Token (fetch error).");
                    console.error(err);
                });
        });
    });
</script>

@endsection
