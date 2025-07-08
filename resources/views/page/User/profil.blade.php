@extends('layout.main')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Foto Profil --}}
                    <div class="text-center mb-4">
                        <div class="col-auto d-flex justify-content-center">
                            @php
                                $fotoProfil = Auth::user()->foto_profil ?? 'default.png';
                            @endphp
                            <img src="{{ asset('storage/foto_profil/' . $fotoProfil) }}"
                                alt="Foto Profil"
                                class="rounded-circle border"
                                style="width: 130px; height: 130px; object-fit: cover; border: 3px solid #bb9587;">
                        </div>
                        <h3 class="mt-3 text-capitalize fw-bold" style="color: #bb9587;">
                            {{ Auth::user()->username }}
                        </h3>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>

                    <hr style="border-top: 2px solid #bb9587;">

                   <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Tanggal Bergabung</h6>
                            <p class="fw-semibold">
                                {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y') }}
                            </p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">No. Telepon</h6>
                            <p class="fw-semibold">{{ Auth::user()->no_telephone ?? 'tidak ada telephone' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6 class="text-muted">Alamat</h6>
                            <p class="fw-semibold">{{ Auth::user()->alamat ?? 'tidak ada alamat' }}</p>
                        </div>
                    </div>


                    <div class="text-center mt-4">
                        <a href="#" class="mt-2 btn px-4 rounded-pill shadow-sm"
                            style="background-color: #bb9587; color: white;">Edit Profil</a>

                        <a href="{{ route('dashboard_hewan') }}" class="mt-2 btn btn-outline-secondary px-4 rounded-pill shadow-sm ms-2">Kembali</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
