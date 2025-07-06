@extends('layout.layout_penyedia')

@section('content2')
<style>
    .btn-custom {
        background-color: #bb9587;
        color: white;
        border: none;
    }

    .btn-custom:hover {
        background-color: #a37d6f;
        color: white;
    }

    .btn-outline-custom {
        color: #bb9587;
        border: 1px solid #bb9587;
        background-color: transparent;
    }

    .btn-outline-custom:hover {
        background-color: #d9b8ae;
        color: white;
        border-color: #a37d6f;
    }

    .form-section {
        background-color: #fdf8f6;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    label {
        font-weight: 500;
        color: #5a4a45;
    }

    h3, h5 {
        color: #bb9587;
    }

    @media (max-width: 576px) {
        .form-section {
            padding: 20px;
        }

        h3 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;      /* Firefox */
    -ms-overflow-style: none;   /* IE 10+ */
">
    <div class="form-section">
        <h3 class="mb-4">Tambah Layanan Baru</h3>
        <form action="{{ route('layanan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga_dasar" class="form-control" required min="0">
            </div>
            <div class="mb-3">
                <label>Deskripsi Layanan</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Opsional..."></textarea>
            </div>



            <div class="mb-3">
                <label>Tipe Layanan</label>
                <select name="tipe_input" class="form-control" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="penitipan">Penitipan</option>
                    <option value="antar jemput">Antar Jemput</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <hr>
            <h5 class="mb-3">Variasi Layanan</h5>
            <div id="variasi-container"></div>

            <button type="button" onclick="tambahVariasi()" class="btn btn-outline-custom mb-4 rounded-pill">+ Tambah Variasi</button>

            <div class="d-flex">
                <button type="submit" class="btn btn-custom rounded-pill px-4 m-2">Simpan Layanan</button>
                <a href="{{ route('layanansaya') }}" class="btn btn-outline-custom rounded-pill px-4">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    let count = 0;

    function tambahVariasi() {
        count++;
        const container = document.getElementById('variasi-container');
        const html = `
            <div class="border p-3 mb-3 rounded shadow-sm bg-white">
                <h6 class="text-muted mb-3">Variasi ${count}</h6>
                <div class="mb-2">
                    <label>Nama Variasi</label>
                    <input type="text" name="variasi[${count}][nama]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Harga</label>
                    <input type="number" name="variasi[${count}][harga]" class="form-control" required min="0">
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
