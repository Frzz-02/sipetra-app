<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verifikasi Data Hewan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #e6b6a3;
      font-family: sans-serif;
    }

    .form-card {
      box-shadow: 6px 6px 0px 0px #c9b3a9;
      max-width: 900px;
    }

    input[type="file"] {
      display: none;
    }

    .upload-box {
      cursor: pointer;
    }

    .radio-check:checked {
      background-color: #f04e00 !important;
      border-color: #f04e00 !important;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="d-flex align-items-center justify-content-between px-3 py-2 shadow-sm" style="background: linear-gradient(to bottom, #dba18f, #dba18f);">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-secondary btn-sm rounded-circle">
        <i class="fas fa-bars text-secondary"></i>
      </button>
      <div class="rounded-circle border border-secondary" style="width: 32px; height: 32px; background-color: #dba18f;"></div>
      <span class="text-dark small">Checkout</span>
    </div>
    <nav class="d-flex gap-3 small fw-semibold text-white">
      <a href="#" class="text-white text-decoration-none">Pusat bantuan</a>
      <a href="#" class="text-white text-decoration-none">Pilih bahasa</a>
      <a href="#" class="text-white text-decoration-none">Akun saya</a>
    </nav>
  </header>

  <!-- Top Bar -->
  <div class="container my-3">
    <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded shadow-sm">
      <a href="#" class="btn btn-outline-danger btn-sm">
        <i class="fas fa-undo-alt me-1"></i> Kembali
      </a>
      <h5 class="mb-0 small text-muted">Verifikasi Data Hewan</h5>
      <button class="btn btn-outline-danger btn-sm">
        <i class="fas fa-save me-1"></i> Simpan
      </button>
    </div>
  </div>

  <!-- Main Form -->
  <div class="container d-flex justify-content-center">
    <div class="bg-white p-4 rounded form-card w-100">
        @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Tampilkan pesan sukses --}}
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
      <form class="row g-4 small text-muted" action="{{ route('hewan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Jenis Hewan -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            Masukkan Nama Hewan <span class="text-danger">*</span>
            <span class="float-end text-muted small">0/50</span>
          </label>
          <input type="text" name="nama_hewan" class="form-control form-control-sm" placeholder="Contoh: Kucing, anjing, dll" maxlength="50">
        </div>

        <!-- Ras -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            Jenis Hewan <span class="text-danger">*</span>
            <span class="float-end text-muted small">0/50</span>
          </label>
          <input type="text" name="jenis" class="form-control form-control-sm" placeholder="Contoh: kucing, anjing, kelinci" maxlength="50">
        </div>

        <!-- Umur Hewan -->
        <div class="col-md-6">
        <label for="umur" class="form-label fw-semibold">Umur Hewan <span class="text-danger">*</span></label>
        <input
            type="text"
            id="umur"
            name="umur"
            class="form-control form-control-sm"
            placeholder="Contoh: 6 bulan, 2 tahun"
            required
        >
        </div>

        <!-- Berat Badan -->
        <div class="col-md-6">
        <label for="berat" class="form-label fw-semibold">Berat Badan <span class="text-danger">*</span></label>
        <input
            type="text"
            id="berat"
            name="berat"
            class="form-control form-control-sm"
            placeholder="Contoh: 5 Kg, 12.5 Kg"
            required
        >
        </div>
         <div class="col-md-6">
            <label class="form-label fw-semibold">
                Deskripsi <span class="text-danger">*</span>
                <span class="float-end text-muted small">0/200</span>
            </label>
            <textarea
                class="form-control form-control-sm"
                name="deskripsi"
                rows="3"
                placeholder="Tulis deskripsi singkat tentang hewan, seperti perilaku, kebutuhan khusus, atau riwayat kesehatannya"
                maxlength="200"
                required
            ></textarea>
         </div>



        <!-- Upload Foto -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">Upload foto <span class="text-danger">*</span></label>
          <p class="small text-muted">Mohon unggah bukti kondisi fisik hewan saat ini</p>
          <label for="upload-file" class="border border-secondary border-dashed rounded d-flex flex-column align-items-center justify-content-center p-3 text-center upload-box">
            <i class="fas fa-cloud-upload-alt text-secondary fs-5"></i>
            <strong>Seret atau upload file disini</strong>
            <span class="small">(Maksimal 2 MB)</span>
            <input type="file" name="foto" id="upload-file" />
          </label>
        </div>
        <input type="submit" class="btn btn-success mt-3" value="Verifikasi Data Hewan">
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
