@extends('layout.main')

@push('styles')
    
@endpush




@section('content2')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-warning px-3 shadow-sm"><i
              class="fas fa-shopping-cart fa-sm text-warning-50" style="-webkit-text-stroke: 0px rgb(188, 106, 0);"></i><span class="pl-2" style="font-weight: 800; -webkit-text-stroke: 0.1px rgb(188, 106, 0);"> Pesan layanan</span></a>
    </div>

    

    {{-- Box yang menampung card animal --}}
    <div class="card shadow mb-4">
      <div class="card-header py-2 d-flex justify-content-center align-items-center">
          <h6 class="m-0 font-weight-bold text-primary col">Data hewan kamu</h6>
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm col-auto">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah hewan
          </a>
      </div>

      
      
      <div class="card-body">
        <div class="row px-4">
          
          @for ($i = 1; $i < 4; $i++)
            <!-- kartu/ daftar hewan -->
            <x-animal-card/>
          @endfor
          
        </div>
        
        
          
      </div>
  </div>

@endsection



















{{-- konten lama --}}
@section('content')

    <div class="container-fluid p-3 bg-white profile-card mt-2">
      <div class="p-3 profile-inner">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
            <div class="rounded-circle bg-secondary" style="width: 48px; height: 48px;"></div>
            <div>
              <p class="mb-0 fw-semibold text-dark small">{{Auth::user()->username}}</p>
              <p class="mb-0 text-muted small">{{Auth::user()->email}}</p>
            </div>
          </div>
          <a href="#" class="btn btn-sm btn-outline-secondary d-none d-md-block">
            <button class="btn btn-sm ">
              Pesan Layanan
            </button>
          </a>
        </div>
        <a href="{{ route('cari_layanan') }}" class="btn btn-sm btn-outline-secondary d-none d-md-block">
            <button class="btn btn-sm">
                Pesan Layanan
            </button>
        </a>

        </a>
        
      </div>
    </div>


    <div class="container-fluid px-3 mt-4">
      <div class="bg-white rounded-3 p-3">
          <div class="d-flex flex-row">
              <p class="mb-0 fw-semibold text-dark small">
                  <i class="fas fa-paw me-1"></i>hewan
              </p>
              <a href="{{route('add_hewan')}}" class="btn btn-success">Tambah Hewan</a>
          </div>
        <table class="table table-bordered table-striped mt-2">
              <thead class="table-dark">
                  <tr>
                      <th>No</th>
                      <th>Gambar</th>
                      <th>Nama Hewan</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($hewan as $index => $pet)
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>
                              <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->nama_hewan }}" width="80" height="80" style="object-fit: cover;">
                          </td>
                          <td>{{ $pet->nama_hewan }}</td>
                          <td>{{ $pet->jenis_hewan }}</td>
                          <td>
                              <a href="#" class="btn btn-sm btn-primary">Detail</a>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
      </div>

@endsection
