@extends('layout.main')

@section('content2')
<div class="container py-4" style="
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

    <h3>Riwayat Pesanan</h3>

    @if($pesanans->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat pesanan.
        </div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Layanan</th>
                    <th>Tanggal Pesan</th>
                    <th>Status</th>
                    <th>Total Biaya</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanans as $index => $pesanan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ optional($pesanan->details->first()->layanan)->nama_layanan ?? '-' }}
                        </td>
                        <td>{{ date('d-m-Y', strtotime($pesanan->tanggal_pesan)) }}</td>
                        <td>
                           <span class="badge
                                @if($pesanan->status == 'selesai') bg-success text-white
                                @elseif($pesanan->status == 'diproses') bg-warning text-dark
                                @elseif($pesanan->status == 'batal') bg-danger text-white
                                @elseif($pesanan->status == 'menunggu') bg-secondary text-white
                                @else bg-light text-dark
                            @endif">
                                {{ ucfirst($pesanan->status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($pesanan->total_biaya) }}</td>
                        <td>
                            <a href="{{ route('pembayaran.lanjutkan', $pesanan->id) }}" class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
