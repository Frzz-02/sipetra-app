@extends('layout.auth')

  @push('styles')
    
      body {
        background: linear-gradient(to bottom right, #c9a99a, #bda18a);
        font-family: 'Poppins', sans-serif;
      }
      h1 {
        font-family: 'Fredoka One', cursive;
      }
      .form-control::placeholder {
        color: #c9a99a;
        font-size: 0.75rem;
      }
      .form-control {
        font-size: 0.75rem;
        color: #c9a99a;
      }
      .btn-register {
        background-color: #c9a99a;
        color: black;
        font-weight: 600;
        font-size: 0.75rem;
        border-radius: 0.375rem;
      }
      .btn-register:hover,
      .btn-register:focus {
        background-color: #b89a8a;
        color: black;
      }
      .image-container img {
        max-width: 100%;
        max-height: 300px;
        filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.25));
        border-radius: 0.25rem;
      }
  @endpush

  
  


@section('content')
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-center">

      <!-- Form Register -->
      <div class="col-12 col-md-6 col-lg-4 bg-white p-4 rounded-end">
        <h1 class="text-center mb-2">Register</h1>
        <p class="text-center small">Silahkan isi data akun anda di bawah ini</p>
        <form action="{{route('register')}}" method="POST">
            @csrf
          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-end-0">
              <i class="fas fa-envelope"></i>
            </span>
            <input type="email" name="email" class="form-control border-start-0" placeholder="Masukkan Email" />
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-end-0">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan Password" />
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-end-0">
              <i class="fas fa-user"></i>
            </span>
            <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan Username" />
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text bg-transparent border-end-0">
              <i class="fas fa-phone"></i>
            </span>
            <input type="tel" name="no_telephone" class="form-control border-start-0" placeholder="Masukkan Nomor Telepon" />
          </div>

          <button type="submit" class="btn btn-register w-100 mt-3">Register</button>
        </form>

        <p class="text-center small mt-2">Sudah mempunyai akun ? <a href="#">Login</a></p>
        <p class="text-center small mt-2">ingin bermitra dengan kami ? <a href="{{route('registrasi_penyedia')}}">klik ini</a></p>
      </div>

      <!-- Gambar (Hanya Muncul di md ke atas) -->
      <div class="col-md-5 d-none d-md-block d-flex align-items-center justify-content-center">
        <div class="image-container">
          <img src="https://storage.googleapis.com/a1aa/image/6ce507a0-d12a-42a0-cc60-63414adceddf.jpg" alt="illustration" />
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection