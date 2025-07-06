@extends('layout.main')

@section('content2')
<div class="py-4" style="max-height: calc(100vh - 100px); overflow-y: scroll; scrollbar-width: none; -ms-overflow-style: none;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{ route('hewan.update', $hewan->id) }}" method="POST" enctype="multipart/form-data" class="card shadow-lg border-0 rounded-4">
                @csrf
                @method('PUT')

                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <div class="col-auto d-flex justify-content-center">
                            <img src="{{ asset('assets/hewan/' . $hewan->foto_hewan) }}"
                                 alt="{{ $hewan->nama_hewan }}"
                                 class="rounded-circle border border-dark shadow"
                                 style="width: 130px; height: 130px; object-fit: cover;">
                        </div>
                        <div class="mt-3">
                            <label for="foto_hewan" class="btn btn-sm btn-outline-secondary rounded-pill shadow-sm">Ubah Foto</label>
                            <input type="file" id="foto_hewan" name="foto_hewan" class="d-none">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group mb-3">
                        <label for="nama_hewan" class="text-muted">Nama Hewan</label>
                        <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_hewan" class="text-muted">Jenis Hewan</label>
                        <input type="text" name="jenis_hewan" id="jenis_hewan" class="form-control" value="{{ old('jenis_hewan', $hewan->jenis_hewan) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_lahir" class="text-muted">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $hewan->tanggal_lahir) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="umur" class="text-muted">Umur</label>
                        <input type="text" name="umur" id="umur" class="form-control" value="{{ old('umur', $hewan->umur) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="berat" class="text-muted">Berat</label>
                        <input type="text" name="berat" id="berat" class="form-control" value="{{ old('berat', $hewan->berat) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="text-muted">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $hewan->deskripsi) }}</textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-warning px-4 rounded-pill shadow-sm">Simpan Perubahan</button>
                        <a href="{{ route('hewan.show', $hewan->id) }}" class="btn btn-secondary px-4 rounded-pill shadow-sm ms-2">Batal</a>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection
