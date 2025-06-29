@extends('layout.auth')


  @push('styles')
      body {
        font-family: 'Poppins', sans-serif;
        background-color: #bb9587;
      }

      .font-fredoka {
        font-family: 'Fredoka One', cursive;
      }

      .font-poppins {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-style: normal;
      }

      .font-openSans {
        font-family: 'Open Sans', sans-serif;
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

      .custom-size{
        max-width: 60%;
      }



      /* untuk tampilan mobile */
      @media(min-width: 0px) and (max-width: 767px){
        {{-- .form-desktop {
          display: none !important;
        } --}}
        .form-mobile {
          display: block !important;
        }

        .rounded-start-5{
          border-radius: 10vw !important;
          border-radius: 10vw !important;
        }
      }

      .custom-shadow {
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
      }

      .img-cat {
        top: 28%;
        left: 20%;
      }
      .img-computer {
        top: 18%;
        left: 15%;
      }

      @media(max-width: 970px){
        .img-cat {
          top: 35%;
          left: 20%;
        }
        .img-computer {
          top: 25%;
          left: 15%;
        }
      }

      .l-judul{
        font-size: 28pt;
      }

      .l-subjudul{
        font-size: 15pt;
      }

      @media(max-width: 810px){
        .l-judul{
          font-size: 23pt;
        }

        .l-subjudul{
          font-size: 13pt;
        }
      }
  @endpush











@section('content')
      <div class="container-fluid min-vh-100 d-md-flex d-none flex-column flex-md-row p-0">
        <!-- Gambar kiri (sembunyi di mobile) -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">

          <div class="h-100 w-100 position-relative">
            <div class="mt-5 ms-5 pt-3 ps-3">
              <h1 class="text-start font-fredoka fw-light custom-shadow text-white text-dark mb-3 pe-5 l-judul" style="">Selamat Datang di SIPETRA 🐾</h1>
              <p class="text-start font-openSans text-white small mb-4 mt-2 pe-5 l-subjudul" style="">Temukan layanan terbaik untuk hewan kesayangan Anda — cepat, aman dan terpercaya.</p>
            </div>

            <img
              src="{{ asset('assets/image/computer.png') }}"
              alt="Login Illustration"
              class="img-fluid position-absolute custom-size img-cat"
              style="transform: translateY(20%);"
            />

            <img
              src="{{ asset('assets/image/catAndBook.png') }}"
              alt="Login Illustration"
              class="img-fluid position-absolute custom-size z-n1 img-computer"
              style="transform: translateY(20%);"
            />
          </div>
        </div>





        <!-- Form kanan desktop -->
        <div class="shadow bg-dark col-md-6 col-12 container my-5 my-md-0 mx-5 mx-md-0 border  bg-white border-dark rounded-start-5 d-flex justify-content-center align-items-center  p-4">
          <form class="form-wrapper" action="{{route('signin.post')}}" method="POST">
              @csrf
            <h1 class="font-fredoka text-center text-dark mb-2 fw-bold">Login</h1>
            <p class="text-center text-muted small mb-4">Silahkan isi data akun anda di bawah ini</p>

            <!-- Email -->
            <div class="mb-3 input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-envelope text-secondary"></i>
              </span>
              <input
                type="email"
                name="email"
                class="form-control border-start-0 email-desktop"
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
                class="form-control border-start-0 password-desktop"
                placeholder="Masukkan Password"
                required
              />
            </div>

            <!-- Submit -->
            <button type="submit" class="btn w-100 text-white" style="background-color: #bb9587">
              Login
            </button>





            <!-- Link register -->
            <p class="text-end mt-3 small text-muted">
              Belum mempunyai akun?
              <a href="{{route('signup')}}" class="text-decoration-none fw-semibold text-primary">Register</a>
            </p>




            <!-- Divider -->
            <p class="text-center mt-5 mb-4 small text-muted">Atau login menggunakan</p>





            <!-- Social login -->
            <div class="d-grid gap-2">
              <button type="button" class="btn btn-light border text-muted w-100 position-relative">
                  <i class="fab fa-google position-absolute top-50 start-0 ms-3 ms-md-4  translate-middle-y"></i>
                  <span class="d-block text-center w-100">Login dengan<span class="fw-semibold ms-3">Google</span></span>
              </button>

              <button type="button" class="btn btn-light border text-muted w-100 position-relative">
                <i class="fab fa-facebook position-absolute top-50 start-0 ms-3 ms-md-4  translate-middle-y"></i>
                <span class="d-block text-center w-100">Login dengan<span class="fw-semibold ms-3">Facebook</span></span>
              </button>

              <button type="button" class="btn btn-light border text-muted w-100 position-relative">
                <i class="fas fa-envelope position-absolute top-50 start-0 ms-3 ms-md-4  translate-middle-y"></i>
                <span class="d-block text-center w-100">Login dengan<span class="fw-semibold ms-3">Email</span></span>
              </button>
            </div>





          </form>
        </div>
      </div>

      {{-- tampilan form mobile --}}
      <section class="vh-100 gradient-custom d-block d-md-none">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card text-dark shadow border border-dark rounded rounded-5" style="border-radius: 1rem;">
                <div class="card-body p-3 text-center">

                  {{-- start form --}}
                  <form action="{{route('signin.post')}}" class="form-wrapper" method="POST" style="">
                    @csrf
                    <div class="mb-md-5 mt-md-4 pb-3">
                      <h1 class="fw-bold mb-2 font-fredoka">Login</h2>
                      <p class="text-dark-50 text-muted mb-5">Silahkan isi data akun anda di bawah ini</p>


                      <div class="form-outline form-white mb-4 text-start">
                        <label class="form-label text-muted" for="typeEmailX">Email</label>
                        <input type="email" id="typeEmailX" name="email" class="email-mobile form-control form-control-lg" />
                      </div>


                      <div class="form-outline form-white mb-3 text-start">
                        <label class="form-label text-muted " for="typePasswordX">Password</label>
                        <input type="password" id="typePasswordX" name="password" class="password-mobile form-control form-control-lg" />
                      </div>


                      <p class="small mb-5 pb-lg-2 text-end">Belum mempunyai akun ? <a class="text-dark-50 text-end" href="{{ route('signup') }}">Register</a></p>

                      <button class="btn btn-outline-dark btn-lg px-5 mt-3" type="submit">Login</button>
                    </form>
                    {{-- end form --}}




                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                      <a href="#!" class="text-dark"><i class="fab fa-facebook-f fa-lg"></i></a>
                      <a href="#!" class="text-dark"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                      <a href="#!" class="text-dark"><i class="fab fa-google fa-lg"></i></a>
                    </div>

                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>
      </section>




      <script>
        const email_Mobile = document.getElementsByClassName('email-mobile').email;
        const pw_Mobile = document.getElementsByClassName('password-mobile').password;
        const email_Desktop = document.getElementsByClassName('email-desktop').email;
        const pw_Desktop = document.getElementsByClassName('password-desktop').password;

        email_Mobile.addEventListener('input', function() {
          email_Desktop.value = this.value;
        });
        pw_Mobile.addEventListener('input', function() {
          pw_Desktop.value = this.value;
        });
        email_Desktop.addEventListener('input', function() {
          email_Mobile.value = this.value;
        });
        pw_Desktop.addEventListener('input', function() {
          pw_Mobile.value = this.value;
        });

      </script>



@endsection
