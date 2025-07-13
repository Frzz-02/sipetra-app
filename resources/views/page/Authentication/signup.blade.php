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

        .custom-size{
          max-width: 60%;
        }
        .custom-shadow {
          text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }


        .img-catsit {
          top: 28%;
          left: 20%;
        }
        .img-catplant {
          max-width: 35%;
          top: 50%;
          left: 60%;
        }

        @media(max-width: 970px){
          .img-catsit {
            top: 45%;
            left: 20%;
          }
          .img-catplant {
            top: 60%;
            left: 55%;
          }
        }

        @media(max-width: 1160px) and (min-width: 970px){
          .img-catsit {
            top: 35%;
            left: 20%;
          }
          .img-catplant {
            top: 60%;
            left: 55%;
          }
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

      <!-- Form Register -->
      <div class="shadow bg-dark col-md-6 col-12 container my-5 my-md-0 mx-5 mx-md-0 border border-1 bg-white border-dark rounded-end-5 d-flex justify-content-center align-items-center p-4">
        <form class="form-wrapper" action="{{route('register')}}" method="POST" >
          @csrf
        <h1 class="font-fredoka text-center text-dark mb-2">Register</h1>
        <p class="text-center text-muted small mb-4">Silahkan isi data akun anda di bawah ini</p>



        {{-- email --}}
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-envelope"></i>
            </span>
            <input type="email"
                  name="email"
                  class="form-control border-start-0 email-desktop"
                  placeholder="Masukkan Email"
                  required
                />
          </div>



          {{-- password --}}
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password"
                  name="password"
                  class="form-control border-start-0 password-desktop"
                  placeholder="Masukkan Password"
                  required
                />
          </div>



          {{-- username --}}
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-user"></i>
            </span>
            <input type="text"
                  name="username"
                  class="form-control border-start-0  username-desktop"
                  placeholder="Masukkan Username"
                  required
                />
          </div>



          {{-- no telephone --}}
          <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-phone"></i>
            </span>
            <input type="tel"
                name="no_telephone"
                class="form-control border-start-0  tlp-desktop"
                placeholder="Masukkan Nomor Telepon"
                required
              />
          </div>
          {{-- alamat --}}
        <div class="input-group mb-4">
        <span class="input-group-text" id="basic-addon1">
            <i class="fas fa-map-marker-alt text-secondary"></i>
        </span>
        <input type="text" name="alamat" class="form-control alamat-mobile" placeholder="Masukkan Alamat" aria-label="Alamat" aria-describedby="basic-addon1">
        </div>


          <button type="submit" class="btn w-100 text-white" style="background-color: #bb9587">Register</button>

          <p class="text-end mt-4 mb-2 small text-muted">Sudah mempunyai akun ? <a href="{{ route('signin') }}" class="text-decoration-none fw-semibold text-primary">Login</a></p>
          <p class="text-end small text-muted">Ingin bermitra dengan kami ? <a href="{{route('registrasi_penyedia')}}" class="text-decoration-none fw-semibold text-primary">klik disini</a></p>
        </form>
      </div>






      <!-- Gambar (Hanya Muncul di md ke atas) -->
      <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
        <div class="h-100 w-100 position-relative">
          <div class="mt-5 ms-5 pt-3 ps-3">
            <h1 class="text-start font-fredoka fw-light custom-shadow text-white text-dark mb-3 pe-5 l-judul custom-shadow" style="">Daftar Sekarang di SIPETRA 🐕</h1>
            <p class="text-start font-openSans text-white small mb-4 mt-2 pe-5 l-subjudul" style="">Cukup satu akun untuk menjangkau berbagai layanan terbaik bagi hewan kesayangan Anda.</p>
          </div>

          <img
          src="{{ asset('assets/image/CatSitting.png') }}"
          alt="cat sitting"
          class="img-fluid position-absolute custom-size z-n1 img-catsit"
          style="transform: translateY(20%);"
         />
          <img
          src="{{ asset('assets/image/catAndPlant.png') }}"
          alt="cat and plant "
          class="img-fluid position-absolute img-catplant"
          style="transform: translateY(20%);"
         />
        </div>
      </div>
  </div>




  {{-- tampilan form mobile --}}
  <section class="vh-100 gradient-custom d-block d-md-none">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-dark shadow border border-1 border-dark rounded rounded-5" style="border-radius: 1rem;">
            <div class="card-body p-3 text-center">

              {{-- start form --}}
              <form action="{{route('register')}}" class="form-wrapper" method="POST">
                @csrf
                <div class="mb-md-5 mt-md-4 pb-3">
                  <h1 class="fw-bold mb-2 font-fredoka">Register</h2>
                <p class="text-dark-50 text-muted mb-5" >Cukup satu akun untuk menjangkau berbagai layanan</p>



                  <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-envelope text-secondary"></i>
                    </span>
                    <input type="email" name="email" class="form-control email-mobile" placeholder="Masukkan Email" aria-label="Email" aria-describedby="basic-addon1">
                  </div>


                  <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-lock text-secondary"></i>
                    </span>
                    <input type="password" name="password" class="form-control pw-mobile" placeholder="Masukkan Password" aria-label="Password" aria-describedby="basic-addon1">
                  </div>


                  <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-user text-secondary"></i>
                    </span>
                    <input type="text" name="username" class="form-control usern-mobile" placeholder="Masukkan Username" aria-label="Username" aria-describedby="basic-addon1">
                  </div>


                  <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-phone text-secondary"></i>
                    </span>
                    <input type="tel" name="no_telephone" class="form-control telp-mobile" placeholder="Masukkan Nomor Telepon" aria-label="Telepon" aria-describedby="basic-addon1">
                  </div>




                  <p class="small mb-2 pb-lg-2 text-end" style="font-size: 80%">Ingin bermitra dengan kami ? <a class="text-dark-50 text-end" href="{{ route('registrasi_penyedia') }}">Klik disini</a></p>
                  <p class="small mb-5 pb-lg-2 text-end" style="font-size: 80%">Sudah mempunyai akun ? <a class="text-dark-50 text-end" href="{{ route('signin') }}">Login</a></p>

                  <button class="btn btn-outline-dark btn-lg px-5 mt-3" type="submit">Login</button>
                </form>
                {{-- end form --}}



              </div>



            </div>
          </div>
        </div>
      </div>
    </div>
  </section>









  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
        // Mobile
        const email_Mobile = document.getElementsByClassName('email-mobile').email;
        const pw_Mobile = document.getElementsByClassName('pw-mobile').password;
        const user_Mobile = document.getElementsByClassName('usern-mobile').username;
        const telp_Mobile = document.getElementsByClassName('telp-mobile').no_telephone;
        const alamat_Mobile = document.getElementsByClassName('alamat-mobile')[0];


        // desktop
        const email_Desktop = document.getElementsByClassName('email-desktop').email;
        const pw_Desktop = document.getElementsByClassName('password-desktop').password;
        const user_Desktop = document.getElementsByClassName('username-desktop').username;
        const telp_Desktop = document.getElementsByClassName('tlp-desktop').no_telephone;
        const alamat_Desktop = document.getElementsByClassName('alamat-desktop')[0];


        // email
        email_Mobile.addEventListener('input', function() {
          email_Desktop.value = this.value;
        });

        email_Desktop.addEventListener('input', function() {
          email_Mobile.value = this.value;
        });




        // password
        pw_Mobile.addEventListener('input', function() {
          pw_Desktop.value = this.value;
        });

        pw_Desktop.addEventListener('input', function() {
          pw_Mobile.value = this.value;
        });




        // username
        user_Desktop.addEventListener('input', function() {
          user_Mobile.value = this.value;
        });

        user_Mobile.addEventListener('input', function() {
          user_Desktop.value = this.value;
        });



        // no telephone
        telp_Desktop.addEventListener('input', function() {
          telp_Mobile.value = this.value;
        });

        telp_Mobile.addEventListener('input', function() {
          telp_Desktop.value = this.value;
        });

        // alamat
        alamat_Mobile.addEventListener('input', function() {
        alamat_Desktop.value = this.value;
        });

        alamat_Desktop.addEventListener('input', function() {
        alamat_Mobile.value = this.value;
        });
  </script>


@endsection
