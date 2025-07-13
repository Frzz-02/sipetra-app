@extends('layout.layout_penyedia')

@section('content2')
<div class="py-4">
    <style>
        .scroll-container::-webkit-scrollbar {
            display: none;
        }
        .scroll-container {
            overflow-y: auto;
            max-height: 100%;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .slider-frame {
            background-color: #f0f0f0;
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        @media (min-width: 768px) {
            .equal-height {
                height: 600px;
            }
            .slider-frame {
                height: 600px;
            }
        }

        @media (max-width: 767.98px) {
            .slider-frame {
                height: 300px;
            }
        }
    </style>

    <form action="{{ route('penyedia.update', $penyedia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row flex-column flex-md-row mb-5" style="min-height: 600px;">
            <!-- Kiri: Upload Foto -->
            <div class="col-md-5 mb-4 mb-md-0 equal-height">
                <div class="position-relative shadow-sm rounded slider-frame d-flex align-items-center justify-content-center bg-light">

                    <!-- Preview Foto -->
                    <img id="previewImage"
                         src="{{ $penyedia->foto ? asset('storage/' . $penyedia->foto) : '' }}"
                         class="w-100 h-100 position-absolute top-0 start-0"
                         style="object-fit: cover; display: {{ $penyedia->foto ? 'block' : 'none' }};"
                         alt="Preview Foto">

                    <!-- Tombol + -->
                    <label for="fotoUpload" class="btn btn-light position-relative z-3 rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px; font-size: 24px; cursor: pointer; border: 2px dashed #ccc;">
                        <i class="fas fa-plus"></i>
                    </label>

                    <!-- Tombol Delete -->
                    @if($penyedia->foto)
                    <button type="submit" formaction="{{ route('penyedia.deleteFoto', $penyedia->id) }}" formmethod="POST" class="btn btn-danger position-absolute top-0 end-0 m-2 rounded-circle p-1" style="z-index: 3;">
                        @csrf
                        @method('DELETE')
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endif

                    <input type="file" id="fotoUpload" name="foto" class="d-none" accept="image/*" onchange="previewFoto(event)">
                </div>
            </div>

            <!-- Kanan: Form -->
            <div class="col-md-7 equal-height">
                <div class="p-4 rounded shadow-sm scroll-container h-100" style="background-color: #fdf8f6;">

                    <!-- Nama & Logo -->
                    <div class="mb-3 d-flex align-items-center">
                        <div class="me-2" style="width: 48px; height: 48px; border-radius: 50%; background-color: #fff; padding: 3px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <input type="text" name="nama_toko" value="{{ $penyedia->nama_toko }}" class="form-control border-0 fw-bold" style="color: #bb9587; font-size: 1.5rem;">
                    </div>

                    <!-- Alamat -->
                    <div class="mb-2">
                        <label class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Alamat</label>
                        <input type="text" name="alamat_toko" value="{{ $penyedia->alamat_toko }}" class="form-control">
                    </div>

                    <!-- Rating -->
                    <p><strong>Rating:</strong> {{ number_format($penyedia->ulasan->avg('rating'), 1) }} / 5</p>

                    <!-- Deskripsi -->
                    <div class="mt-4 p-3 bg-white rounded shadow-sm" style="overflow-wrap: break-word; word-break: break-word;">
                        <h5 class="fw-semibold" style="color: #bb9587;">Tentang Toko</h5>
                        <textarea name="deskripsi" class="form-control mt-2" style="height: 150px;">{{ $penyedia->deskripsi }}</textarea>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="mt-4">
                        <button type="submit" class="btn" style="background-color: #bb9587; color: white;">
                            Simpan Perubahan <i class="fas fa-save ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript Preview -->
<script>
    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('previewImage');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
