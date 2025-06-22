@extends('layout.auth')

    @push('styles')
        body, html {
          height: 100%;
          margin: 0;
          background: linear-gradient(to bottom right, #c9a99a, #bda18a);
          font-family: 'Poppins', sans-serif;
        }
        h2 {
          font-family: 'Fredoka One', cursive;
          font-size: 2rem;
        }
    @endpush


    
    


@section('content')
  <div class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="bg-white rounded-4 shadow p-4 p-md-5" style="max-width: 500px; width: 100%;">
      <h2 class="text-center mb-3">Daftar Penyedia Layanan</h2>
      <p class="text-center text-muted small mb-4">Silakan isi data toko dan pemilik di bawah ini</p>
      
      
      
      
      

      <form action="{{route('registerpenyedia')}}" method="POST" class="small text-muted">
        
        
        @csrf
        <!-- Nama Pemilik -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Pemilik <span class="text-danger">*</span></label>
          <input type="text" name="username" class="form-control form-control-sm" placeholder="Masukkan nama lengkap" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control form-control-sm" placeholder="contoh@email.com" required>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control form-control-sm" placeholder="Masukkan password" required>
        </div>

        <!-- No Telephone -->
        <div class="mb-4">
          <label class="form-label fw-semibold">no telephone <span class="text-danger">*</span></label>
          <input type="password" name="no_telephone" class="form-control form-control-sm" placeholder="Masukkan password" required>
        </div>

        <hr class="text-muted">

        <!-- Nama Toko -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Toko <span class="text-danger">*</span></label>
          <input type="text" name="nama_toko" class="form-control form-control-sm" placeholder="Nama toko layanan Anda" required>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
          <textarea name="alamat_toko" rows="2" class="form-control form-control-sm" placeholder="Alamat lengkap" required></textarea>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi Toko (opsional)</label>
          <textarea name="deskripsi" rows="3" class="form-control form-control-sm" placeholder="Jelaskan layanan atau keunggulan toko Anda"></textarea>
        </div>

        <button type="submit" class="btn w-100 text-white fw-semibold" style="background-color: #c9a99a;">Daftar</button>
        
        
      </form>
    </div>
  </div>
@endsection