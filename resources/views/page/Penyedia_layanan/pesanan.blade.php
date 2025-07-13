@extends('layout.layout_penyedia')

@section('content2')
<div class="py-4 " style="max-height: calc(100vh - 100px); overflow-y: scroll;">
    <h2 class="mb-4">Pesanan</h2>

    @if ($pesananPerLayanan)
        <div class="row">
            @forelse ($pesananPerLayanan as $namaLayanan => $daftarPesanan)
                <div class="col-12 col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Layanan: {{ $namaLayanan }}</h5>
                        </div>

                        <div class="card-body pb-0">
                            <p class="mb-0"><strong>Total Pesanan:</strong> {{ $daftarPesanan->count() }} pesanan</p>
                        </div>

                        <div class="card-body table-responsive pt-3">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama & Status</th>
                                        <th>Total Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftarPesanan as $pesanan)
                                        <tr onclick="window.location='{{ route('penyedia.pesanan.detail', $pesanan->id) }}'" style="cursor:pointer;">
                                            <td>
                                                <strong>{{ $pesanan->user->username ?? 'User' }}</strong><br>
                                                <span class="badge
                                                    @switch($pesanan->status)
                                                        @case('menunggu diproses') bg-warning text-dark @break
                                                        @case('diproses') bg-primary @break
                                                        @case('selesai') bg-success @break
                                                        @default bg-secondary
                                                    @endswitch
                                                ">
                                                    {{ ucfirst($pesanan->status) }}
                                                </span>
                                            </td>
                                            <td>Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center">Belum ada pesanan</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Belum ada layanan atau pesanan.</div></div>
            @endforelse
        </div>
    @else
        <div class="alert alert-info">Belum ada layanan atau pesanan.</div>
    @endif
</div>
@endsection
