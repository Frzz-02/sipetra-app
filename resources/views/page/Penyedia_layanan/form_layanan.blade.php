@extends('layout.auth')

@section('content')
<div class="container mt-5">
    <h3>Tambah Layanan Baru</h3>
    <form action="{{ route('layanan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Layanan</label>
            <input type="text" name="nama_layanan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi Layanan</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Harga Dasar (Rp)</label>
            <input type="number" name="harga_dasar" class="form-control" required min="0">
        </div>

        <hr>
        <h5>Variasi Layanan</h5>
        <div id="variasi-container"></div>

        <button type="button" onclick="tambahVariasi()" class="btn btn-secondary mb-3">+ Tambah Variasi</button>

        <button type="submit" class="btn btn-primary">Simpan Layanan</button>
    </form>
</div>

<script>
    let count = 0;

    function tambahVariasi() {
        count++;
        const container = document.getElementById('variasi-container');
        const html = `
            <div class="border p-3 mb-3">
                <h6>Variasi ${count}</h6>
                <div class="mb-2">
                    <label>Nama Variasi</label>
                    <input type="text" name="variasi[${count}][nama]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Harga Tambahan (Rp)</label>
                    <input type="number" name="variasi[${count}][harga]" class="form-control" required min="0">
                </div>
                <div class="mb-2">
                    <label>Jumlah</label>
                    <input type="text" name="variasi[${count}][opsi]" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Deskripsi Variasi</label>
                    <textarea name="variasi[${count}][deskripsi]" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }
</script>

@endsection
