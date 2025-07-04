@extends('layout.main')

@section('content2')
<div class="container py-4">
  <div class="card shadow border-0">
    <div class="card-body">
      <h4 class="text-primary mb-4">Verifikasi Data Hewan</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form class="row g-4 small text-muted" action="{{ route('hewan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">


        <div class="col-md-6">
          <label class="form-label fw-semibold">Masukkan Nama Hewan <span class="text-danger">*</span></label>
          <input type="text" name="nama_hewan" class="form-control form-control-sm" placeholder="nama hewan" maxlength="50">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Jenis Hewan <span class="text-danger">*</span></label>
          <input type="text" name="jenis" class="form-control form-control-sm" placeholder="Contoh: kucing, anjing, kelinci" maxlength="50">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
          <input type="date" name="tanggal_lahir" class="form-control form-control-sm" max="{{ date('Y-m-d') }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Berat Badan <span class="text-danger">*</span></label>
          <input type="text" name="berat" class="form-control form-control-sm" placeholder="Contoh: 5 Kg, 12.5 Kg" required>
        </div>

        <div class="col-md-12">
          <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
          <textarea class="form-control form-control-sm" name="deskripsi" rows="3" placeholder="Tulis deskripsi singkat tentang hewan, seperti perilaku, kebutuhan khusus, atau riwayat kesehatannya" maxlength="200" required></textarea>
        </div>

        <div class="col-md-12">
          <label class="form-label fw-semibold">Upload Foto <span class="text-danger">*</span></label>
          <p class="small text-muted">Mohon unggah bukti kondisi fisik hewan saat ini</p>
          <input class="form-control form-control-sm" type="file" name="foto" required>
        </div>

        <div class="col-12 text-end mt-3">
          <button type="submit" class="btn btn-success">Tambah Hewan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
