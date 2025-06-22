<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Toko</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9f5f2;
    }
    .sidebar {
      background-color: #c9a99a;
      min-height: 100vh;
      padding-top: 1.5rem;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 15px;
      border-radius: 0.375rem;
      margin-bottom: 10px;
      text-decoration: none;
      font-size: 14px;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #b8947d;
    }
    .navbar-custom {
      background: linear-gradient(to right, #c9a99a, #bda18a);
    }
    h1 {
      font-family: 'Fredoka One', cursive;
      font-size: 1.8rem;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block sidebar">
        <div class="text-center mb-4">
          <h1 class="text-white">TokoKu</h1>
        </div>
        <a href="#" class="active">Dashboard</a>
        <a href="{{route('layanansaya')}}">Layanan Saya</a>
        <a href="#">Pesanan Masuk</a>
        <a href="#">Hewan Pelanggan</a>
        <a href="#">Pengaturan Akun</a>
        <a href="#">Keluar</a>
      </nav>

      <!-- Main -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold">Dashboard Toko</h2>
          <span class="text-muted">Selamat datang, {{Auth::user()->penyedia->nama_toko}}</span>
        </div>

        <!-- Cards -->
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="card-title text-muted">Pesanan Hari Ini</h6>
                <h4 class="fw-bold">5</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="card-title text-muted">Total Layanan</h6>
                <h4 class="fw-bold">8</h4>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="card-title text-muted">Ulasan Masuk</h6>
                <h4 class="fw-bold">12</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Table -->
        <div class="mt-5">
          <h5 class="fw-bold mb-3">Pesanan Terbaru</h5>
          <div class="table-responsive">
            <table class="table table-bordered align-middle small">
              <thead class="table-light">
                <tr>
                  <th>Nama Pemesan</th>
                  <th>Layanan</th>
                  <th>Hewan</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Andi</td>
                  <td>Grooming</td>
                  <td>Kucing</td>
                  <td>20 Juni 2025</td>
                  <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                </tr>
                <tr>
                  <td>Sita</td>
                  <td>Penitipan</td>
                  <td>Anjing</td>
                  <td>19 Juni 2025</td>
                  <td><span class="badge bg-success">Selesai</span></td>
                </tr>
                <tr>
                  <td>Budi</td>
                  <td>Pembersihan Kandang</td>
                  <td>Kelinci</td>
                  <td>18 Juni 2025</td>
                  <td><span class="badge bg-danger">Dibatalkan</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </main>
    </div>
  </div>
</body>
</html>
