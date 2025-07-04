@extends('layout.main')

@section('content2')
<div class="py-4" style="max-height: calc(100vh - 100px); overflow-y: scroll; scrollbar-width: none; -ms-overflow-style: none;">
    <style>
        .container::-webkit-scrollbar {
            display: none;
        }

        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .clickable-row:hover {
            background-color: #f8f9fa;
        }

        @media (max-width: 576px) {
            .table td, .table th {
                font-size: 0.875rem;
            }
        }
    </style>

    <h3 class="mb-3">Riwayat Pesanan</h3>

    @if($pesanans->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat pesanan.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Layanan & Tanggal</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $pesanan)
                        @php
                            $link = $pesanan->status === 'menunggu pembayaran'
                                ? route('pembayaran.lanjutkan', $pesanan->id)
                                : route('pesanan.detail', $pesanan->id); // Ganti jika route detail berbeda
                        @endphp
                        <tr class="clickable-row" onclick="window.location='{{ $link }}'">
                            <td>
                                <div class="d-flex flex-column">
                                    <strong>{{ optional($pesanan->details->first()->layanan)->nama_layanan ?? '-' }}</strong>
                                    <span>{{ date('d-m-Y', strtotime($pesanan->tanggal_pesan)) }}</span>
                                     <div class="d-inline-block">
                                        <span class="badge mt-1 w-auto d-inline-block
                                            @switch($pesanan->status)
                                                @case('menunggu pembayaran') bg-dark text-white @break
                                                @case('menunggu diproses') bg-warning text-dark @break
                                                @case('diproses') bg-info text-white @break
                                                @case('selesai') bg-success text-white @break
                                                @case('batal') bg-danger text-white @break
                                                @default bg-light text-dark
                                            @endswitch
                                        ">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                     </div>
                                </div>
                            </td>
                            <td class="align-middle">Rp {{ number_format($pesanan->total_biaya) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
