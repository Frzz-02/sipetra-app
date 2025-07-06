@extends('layout.layout_penyedia')

@section('content2')
<div class="container mt-5">
    <h2 class="mb-4" style="color: #bb9587;">Edit Variasi Layanan</h2>

    <form action="{{ route('detail_layanan.update', $detail->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tipe" class="form-label">Nama Tipe Layanan</label>
            <input type="text" class="form-control" id="tipe" name="tipe" value="{{ old('tipe', $detail->tipe) }}" required>
        </div>

        <div class="mb-3">
            <label for="harga_dasar" class="form-label">Harga Dasar</label>
            <input type="number" class="form-control" id="harga_dasar" name="harga_dasar" value="{{ old('harga_dasar', $detail->harga_dasar) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="opsi" class="form-label">Opsi Tambahan</label>
            <input type="text" class="form-control" id="opsi" name="opsi" value="{{ old('opsi', $detail->opsi) }}">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $detail->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-custom px-4">Simpan Perubahan</button>
        <a href="{{ route('layanansaya') }}" class="btn btn-outline-custom px-4">Kembali</a>
    </form>
</div>
@endsection
