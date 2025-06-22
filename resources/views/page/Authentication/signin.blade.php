@extends('layout.auth')


  @push('styles')
      body {
        font-family: 'Poppins', sans-serif;
        background-color: #bb9587;
      }

      .font-fredoka {
        font-family: 'Fredoka One', cursive;
      }

      .form-control::placeholder {
        font-size: 0.85rem;
      }

      .form-wrapper {
        max-width: 500px;
        width: 100%;
        /* background: #ffffff; */
        padding: 2rem;
        /* border-radius: 1rem; */
        /* box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); */
      }

      .bg-custom {
        background-color: #bb9587;
      }

      /* untuk tampilan mobile */
      @media(min-width: 0px) and (max-width: 767px){
        .form-mobile {
          justify-content: center !important;
          align-items: center !important;
        }

        .rounded-start-5{
          border-radius: 10vw !important;
          border-radius: 10vw !important;
        }
      }
  @endpush











@section('content')
      <div class="container-fluid min-vh-100 d-flex flex-column flex-md-row p-0  form-mobile">
        <!-- Gambar kiri (sembunyi di mobile) -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center ">
          <img
            src="{{ asset('assets/image/computer.png') }}"
            alt="Login Illustration"
            class="img-fluid"
            style="max-width: 400px"
          />
        </div>

        
        
        
        
        
        
        <!-- Form kanan / tengah jika mobile -->
        <div class="col-md-6 col-12 container my-5 my-md-0 mx-5 mx-md-0  border border-1 bg-white border-dark rounded-start-5 d-flex justify-content-center align-items-center  p-4">
          <form class="form-wrapper" action="{{route('signin.post')}}" method="POST">
              @csrf
            <h1 class="font-fredoka text-center text-dark mb-2">Login</h1>
            <p class="text-center text-muted small mb-4">Silahkan isi data akun anda di bawah ini</p>

            <!-- Email -->
            <div class="mb-3 input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-envelope text-secondary"></i>
              </span>
              <input
                type="email"
                name="email"
                class="form-control border-start-0"
                placeholder="Masukkan Email"
                required
              />
            </div>

            <!-- Password -->
            <div class="mb-4 input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-lock text-secondary"></i>
              </span>
              <input
                type="password"
                name="password"
                class="form-control border-start-0"
                placeholder="Masukkan Password"
                required
              />
            </div>

            <!-- Submit -->
            <button type="submit" class="btn w-100 text-white" style="background-color: #bb9587">
              Login
            </button>
            
            
            
            

            <!-- Link register -->
            <p class="text-center mt-3 small text-muted">
              Belum mempunyai akun?
              <a href="{{route('signup')}}" class="text-decoration-none fw-semibold text-primary">Register</a>
            </p>
            
            
            

            <!-- Divider -->
            <p class="text-center mt-4 mb-2 small text-muted">Atau login menggunakan</p>

            
            
            

            <!-- Social login -->
            <div class="d-grid gap-2">
              <button type="button" class="btn btn-light border text-muted">
                <i class="fab fa-google me-2"></i>Login dengan <span class="fw-semibold">Google</span>
              </button>
              <button type="button" class="btn btn-light border text-muted">
                <i class="fab fa-facebook me-2"></i>Login dengan <span class="fw-semibold">Facebook</span>
              </button>
              <button type="button" class="btn btn-light border text-muted">
                <i class="fas fa-envelope me-2"></i>Login dengan <span class="fw-semibold">Email</span>
              </button>
            </div>





          </form>
        </div>
      </div>
      
@endsection
