@extends('layout.layout_penyedia')

@section('content2')
<div class="py-4" style="max-height: calc(100vh - 100px); overflow-y: scroll;">
    <h2 class="mb-4">Pesanan Selesai</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Daftar Pesanan</h5>
        </div>

        <div class="card-body pb-0">
            <p class="mb-0"><strong>Total Pesanan:</strong> {{ $pesanan->count() }} pesanan</p>
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
                    @forelse($pesanan as $item)
                        <tr onclick="window.location='{{ route('penyedia.pesanan.detail', $item->id) }}'" style="cursor:pointer;">
                            <td>
                                <strong>{{ $item->user->username ?? 'User' }}</strong><br>
                                <span class="badge bg-success text-white">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
