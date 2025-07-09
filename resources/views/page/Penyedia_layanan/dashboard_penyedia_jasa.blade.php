@extends('layout.layout_penyedia')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;      /* Firefox */
    -ms-overflow-style: none;   /* IE 10+ */
">
    <h2 class="mb-4">Dashboard Penyedia Layanan</h2>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <h5>Layanan Terdaftar</h5>
                    <h3>{{ $jumlah_layanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h5>Total Pemesanan</h5>
                    <h3>{{ $jumlah_pesanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <h5>Total Pendapatan (selesai)</h5>
                    <h3>Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Pesanan Terbaru --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Pesanan Terbaru</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan_terbaru as $pesanan)
                        <tr>
                            <td>{{ $pesanan->user->username ?? 'User' }}<br><span class="badge bg-info text-dark">{{ ucfirst($pesanan->status) }}</td>
                            <td>Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{route('penyedia.pesanan.detail', $pesanan->id)}}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
