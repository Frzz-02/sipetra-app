<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Layanan Toko Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PetService</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Layanan Toko Saya</h2>

    <!-- Simulasi alert -->
    <div class="alert alert-success" role="alert">
        Layanan berhasil ditambahkan.
    </div>

    <div class="alert alert-danger" role="alert">
        Layanan ini sudah ditambahkan.
    </div>

    <!-- Form Tambah Layanan -->
    <form method="POST" action="#">
        <!-- Simulasi token CSRF -->
        <input type="hidden" name="_token" value="csrf-token-placeholder">

        <div class="mb-3">
            <label for="id_layanan" class="form-label">Pilih Layanan</label>
            <select class="form-select" name="id_layanan" id="id_layanan" required>
                <option value="">-- Pilih Layanan --</option>
                <option value="1">Penitipan Hewan</option>
                <option value="2">Grooming</option>
                <option value="3">Antar Jemput</option>
                <option value="4">Pembersihan Kandang</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga_dasar" class="form-label">tipe</label>
            <input type="text" class="form-control" name="tipe" id="harga_dasar" min="0" required>
        </div>
        <div class="mb-3">
            <label for="harga_dasar" class="form-label">Harga Dasar (Rp)</label>
            <input type="number" class="form-control" name="harga_dasar" id="harga_dasar" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Layanan</button>
    </form>

    <hr class="my-5">

    <!-- Daftar layanan yang sudah ditambahkan -->
    <h4>Layanan yang Sudah Ditambahkan</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Harga Dasar (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Penitipan Hewan</td>
                    <td>50.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Grooming</td>
                    <td>35.000</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Pembersihan Kandang</td>
                    <td>25.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
