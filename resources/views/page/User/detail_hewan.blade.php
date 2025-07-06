@extends('layout.main')

@section('content2')
<div class=" py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;      /* Firefox */
    -ms-overflow-style: none;   /* IE 10+ */
">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                <div class="text-center mb-4">
                    <div class="col-auto d-flex justify-content-center">
                        <img src="{{ asset('assets/hewan/' . $hewan->foto_hewan) }}"
                            alt="{{ $hewan->foto_hewan }}"
                            class="rounded-circle border border-dark shadow"
                            style="width: 130px; height: 130px; object-fit: cover;">
                    </div>
                    <h3 class="mt-3 text-capitalize text-primary fw-bold">{{ $hewan->nama_hewan }}</h3>
                    <p class="text-muted mb-0">{{ $hewan->jenis_hewan }}</p>
                </div>


                    <hr>

                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Tanggal Lahir</h6>
                            <p class="fw-semibold">{{ \Carbon\Carbon::parse($hewan->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Umur</h6>
                            <p class="fw-semibold">{{ $hewan->umur ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Berat</h6>
                            <p class="fw-semibold">{{ $hewan->berat ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Pemilik</h6>
                            <p class="fw-semibold">{{ $hewan->user->username ?? 'Tidak Diketahui' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Deskripsi</h6>
                        <p class="fw-semibold">{{ $hewan->deskripsi ?? '-' }}</p>
                    </div>

                   <div class="text-center mt-4">
                        <a href="{{ route('hewan.edit', ['id' => $hewan->id]) }}" class="mt-2 btn btn-warning px-4 rounded-pill shadow-sm">Edit Data</a>

                        <form action="{{ route('hewan.destroy', ['id' => $hewan->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus hewan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mt-2 btn btn-danger px-4 rounded-pill shadow-sm ms-2">Hapus</button>
                        </form>

                        <a href="{{ route('dashboard_hewan') }}" class="mt-2 btn btn-secondary px-4 rounded-pill shadow-sm ms-2">Kembali</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
