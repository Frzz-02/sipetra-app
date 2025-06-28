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
          <a href="{{route('add_hewan')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm col-auto">
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

              <!-- kartu/ daftar hewan -->
              <x-animal-card 
                  :name="$pet->nama_hewan"
                  :img="$pet->foto_hewan"
                  :birth="$pet->tanggal_lahir"
               />
             {{-- variabel yang diawali ":" mengarah ke parameter konstruktor di file animalCard.php --}}
             
            @endforeach

          @else
            <p class="text-muted text-center w-100 p-5">Data tidak ada</p>
          @endif
          
        </div>



      </div>
  </div>

@endsection
