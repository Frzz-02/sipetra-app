<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Fredoka+One&family=Open+Sans&display=swap" rel="stylesheet" />

    <style>
        @stack('styles')
    </style>

  </head>
  <body>
    <!-- Header -->
    <header class="header-gradient px-3 py-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-light">
          <i class="fas fa-bars"></i>
        </button>
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-light border" style="width: 24px; height: 24px;"></div>
          <span class="text-white small">Dashboard</span>
        </div>
      </div>
      <nav class="d-none d-sm-flex gap-3 text-white small">
        <a href="#" class="text-white text-decoration-none">Pusat bantuan</a>
        <a href="#" class="text-white text-decoration-none">Pilih bahasa</a>
        <a href="#" class="text-white text-decoration-none">Akun saya</a>
      </nav>
    </header>

    @yield('content') 


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>  