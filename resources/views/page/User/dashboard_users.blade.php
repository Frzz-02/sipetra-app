<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #eac9be;
    }
    .header-gradient {
      background: linear-gradient(to right, #c48f7a, #d9a38a);
    }
    .profile-card {
      border-top-left-radius: 40px;
      border-top-right-radius: 40px;
      height: auto;
    }
    .profile-inner {
      background-color: white;
      border-radius: 20px;
      height: 80%;
    }
    .search-input::placeholder {
      font-size: 12px;
    }
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
        <a href="{{ route('cari_layanan') }}" class="btn btn-sm btn-outline-secondary d-none d-md-block">
            <button class="btn btn-sm">
                Pesan Layanan
            </button>
        </a>

        </a>
      </div>
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
s
</body>
</html>
