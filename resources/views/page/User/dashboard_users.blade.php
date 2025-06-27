@extends('layout.main')

@push('styles')

@endpush




@section('content2')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <a href="{{route('cari_layanan')}}" class="d-none d-sm-inline-block btn btn-sm btn-outline-warning px-3 shadow-sm"><i
              class="fas fa-shopping-cart fa-sm text-warning-50" style="-webkit-text-stroke: 0px rgb(188, 106, 0);"></i><span class="pl-2" style="font-weight: 800; -webkit-text-stroke: 0.1px rgb(188, 106, 0);"> Pesan layanan</span></a>
    </div>



    {{-- Box yang menampung card animal --}}
    <div class="card shadow mb-4">
      <div class="card-header py-2 d-flex justify-content-center align-items-center">
          <h6 class="m-0 font-weight-bold text-primary col">Data hewan kamu</h6>
          <a href="{{route('add_hewan')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm col-auto">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah hewan
          </a>
      </div>



      <div class="card-body">
        <div class="row px-4">

            @foreach ($hewan as $pet)
                <x-animal-card :pet="$pet" />
            @endforeach


        </div>



      </div>
  </div>

@endsection
