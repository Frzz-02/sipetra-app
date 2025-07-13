@extends('layout.layout_penyedia')

@section('content2')
<div class="container py-4">
        <div class="my-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="mb-3" style="color: #bb9587;">Ulasan Pengguna</h4>
                @php $ulasanTerbatas = $penyedia->ulasan->sortByDesc('created_at'); @endphp

                @if($ulasanTerbatas->isEmpty())
                    <p class="text-muted">Belum ada ulasan untuk penyedia ini.</p>
                @else
                    @foreach($ulasanTerbatas as $ulasan)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $ulasan->user->username }}</strong>
                                <small class="text-muted">{{ $ulasan->created_at->format('d M Y') }}</small>
                            </div>
                            <div class="text-warning mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $ulasan->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            @if($ulasan->komentar)
                                <p class="mb-0 text-dark">{{ $ulasan->komentar }}</p>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
