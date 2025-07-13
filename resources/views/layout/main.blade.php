<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>



    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/dashboard_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">



    <!-- Font Awesome -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" /> --}}


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Fredoka+One&family=Open+Sans&display=swap" rel="stylesheet" />


    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="{{ asset('assets/dashboard_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard_assets/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- openrouteservice -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />



    <style>
        @stack('styles')
    </style>
    <style>
        @media (max-width: 768px) {
    #accordionSidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1040;
        background-color: #bb9587;
    }
}


        </style>


  </head>
  <body id="page-top">
    <div id="wrapper" style="height: 100vh;">

      {{-- component sidebar --}}
      <x-sidebar_dashboard/>



      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            {{-- bagiam ini adalah component --}}
            <x-navbar_dashboard/>

            <div class="container-fluid">
              @yield('content2')
            </div>
        </div>




      </div>
    </div>





    @yield('content')



    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/dashboard_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Tambahkan ini jika kamu ingin pakai CDN Bootstrap 4 (karena SB Admin 2 butuh Bootstrap 4.x) -->



    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/dashboard_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <!-- Page level plugins -->
    <script src="{{ asset('assets/dashboard_assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/dashboard_assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/dashboard_assets/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
   <script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("sidebarToggleTop");
    const sidebar = document.getElementById("accordionSidebar");

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("d-none");
      });
    }
  });
</script>

</script>

  </body>
  </html>
