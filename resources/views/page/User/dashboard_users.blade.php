@extends('layout.main')

@push('styles')
  .img-size-max{
    min-width: 34px;
    max-width: 50px;
    width: 10%;
    height: 10%;
  }
@endpush




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

    <div class="d-sm-flex align-items-center justify-content-between mb-4 row ">
      <h1 class="col h3 mb-0 text-gray-800 fs-header">Dashboard</h1>

      <a href="{{ route('cari_layanan') }}" class="col-3 d-none d-sm-inline-block btn btn-sm btn-outline-warning px-3 shadow-sm">
        <i class="fas fa-shopping-cart fa-sm text-warning-50" style="-webkit-text-stroke: 0px rgb(188, 106, 0);"></i><span class="pl-2" style="font-weight: 800; -webkit-text-stroke: 0.1px rgb(188, 106, 0);"> Pesan layanan</span>
      </a>

      <a href="{{ route('cari_layanan') }}" class="col-2 d-sm-none d-inline-block btn btn-sm btn-outline-warning px-3 shadow-sm d-flex align-items-center justify-content-center py-2" data-toggle="tooltip" data-placement="bottom" title="Pesan layanan">
        <i class="fas fa-shopping-cart fa-sm text-warning-50" style="-webkit-text-stroke: 0px rgb(188, 106, 0);"></i>
      </a>
    </div>



    {{-- Box yang menampung card animal --}}
    <div class="card shadow mb-4">
      <div class="card-header py-2 d-flex justify-content-center align-items-center">
          <h6 class="m-0 px-sm-2 p-0 font-weight-bold text-primary col" style="font-size: 90%;">Data hewan</h6>
          <a href="{{ route('add_hewan', ['redirect' => url()->current()]) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah hewan
            </a>
          <a href="{{route('add_hewan')}}" class="d-sm-none d-inline-block btn btn-sm btn-primary shadow-sm col-auto" data-toggle="tooltip" data-placement="bottom" title="Tambah hewan">
            <i class="fas fa-plus fa-sm text-white-50"></i>
          </a>
      </div>




      <div class="card-body px-2 pt-3">
        <div class="row px-sm-4 px-0">

          @if ($hewan->count())

            @foreach ($hewan as $pet)
                <div class="col-md-6 col-12 mb-sm-4 mb-2">
                    <a href="{{ route('hewan.show', $pet->id) }}" class="text-decoration-none text-dark">
                        <div class="card border-left-warning shadow h-100 hover-shadow" style="transition: 0.3s; cursor: pointer;">
                            <div class="card-body p-2">
                                <div class="row align-items-center">

                                    {{-- Gambar di kiri --}}
                                    <div class="col-auto d-flex justify-content-center">
                                        <img src="{{ asset('assets/hewan/' . $pet->foto_hewan) }}"
                                            alt="{{ $pet->foto_hewan }}"
                                            class="rounded-circle border border-dark"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    </div>

                                    {{-- Nama dan Tanggal Lahir di kanan --}}
                                    <div class="col pl-2">
                                        <div class="font-weight-medium text-warning text-outline text-capitalize mb-1 text-truncate" style="max-width: 100%;">
                                            {{ $pet->nama_hewan }}
                                        </div>
                                        <div class="h6 font-weight-light text-gray-800 mb-0">
                                            {{ $pet->tanggal_lahir ? \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') : '-' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
          @else
            <p class="text-muted text-center w-100 p-5">Data tidak ada</p>
          @endif

        </div>



      </div>
  </div>

@endsection
