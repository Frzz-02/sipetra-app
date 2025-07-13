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
        .editable:hover {
            background-color: #f7f7f7;
            cursor: pointer;
        }
        .editable-color-box {
            width: 50px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }
        .editable-color-box:hover {
            outline: 2px solid #888;
        }
        .editable:hover {
            background-color: #f7f7f7;
            cursor: pointer;
        }

        .editable-nohover:hover {
            background-color: transparent !important;
            cursor: default;
        }


    </style>

    <div class="row flex-column flex-md-row mb-5" style="min-height: 600px;">
       <!-- Kiri: Galeri Foto seperti Shopee -->
       <div class="col-md-5 mb-4 mb-md-0 equal-height">
           <!-- Gambar Utama dengan Tombol Hapus -->
            <div class="position-relative border rounded shadow-sm mb-2 bg-white" style="height: 450px; overflow: hidden;">

                @if($penyedia->fotos->first())
                <form action="{{ route('penyedia.fotoHapus', $penyedia->fotos->first()->id) }}" method="POST"
                    class="position-absolute start-0 bottom-0 w-100"
                    style="height: 50px; background: rgba(0, 0, 0, 0.5); z-index: 10;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn text-white w-100 h-100 d-flex justify-content-center align-items-center"
                        style="background: transparent; border: none; font-size: 14px;">
                        <i class="fas fa-trash-alt me-2"></i> Hapus Gambar
                    </button>
                </form>
                @endif
                <img id="mainImage"
                    src="{{ asset($penyedia->fotos->first()?->foto ?? 'img/placeholder.png') }}"
                    class="img-fluid w-100 h-100"
                    style="object-fit: cover;">

             </div>

            <!-- Input File Disembunyikan -->
            <input type="file" id="imageUploader" class="d-none" accept="image/*">
           <!-- Thumbnail: Scroll Horizontal -->
            <div class="d-flex overflow-auto flex-nowrap gap-2" style="white-space: nowrap;">
                @foreach($penyedia->fotos as $index => $foto)
                    @if($foto->foto)
                    <div class="thumbnail-wrapper border {{ $index === 0 ? 'border-danger' : '' }}" style="cursor: pointer; flex: 0 0 auto;">
                        <img src="{{ asset($foto->foto) }}"
                            onclick="updateMainImage('{{ asset($foto->foto) }}', this)"
                            class="img-thumbnail"
                            style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    @endif
                @endforeach

                <!-- Tombol Tambah (+) -->
                <div class="thumbnail-wrapper border border-secondary d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 80px; cursor: pointer; flex: 0 0 auto;" onclick="document.getElementById('imageUploader').click()">
                    <i class="fas fa-plus text-secondary"></i>
                </div>
            </div>
        </div>



        <!-- Kanan: Info Toko -->
        <div class="col-md-7 equal-height">
            <div class="p-4 rounded shadow-sm scroll-container h-100" style="background-color: {{ $penyedia->color_heading ?? '#bb9587' }};">

                <!-- Nama Toko -->
                <div class="mb-3 d-flex align-items-center">
                    <div class="mr-2" style="width: 48px; height: 48px; border-radius: 50%; background-color: #fff; padding: 3px; display: flex; align-items: center; justify-content: center;">
                        <img src="#" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="flex-grow-1 d-flex align-items-center">
                        <h3 id="namaToko" class="fw-bold mb-0 me-2 editable mr-1 editable-nohover" data-field="nama_toko" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">{{ $penyedia->nama_toko }}</h3>
                        <i class="fas fa-edit text-muted small edit-icon" style="cursor: pointer;" onclick="editField('namaToko')"></i>
                    </div>
                </div>

                <!-- Alamat -->
                <p class="text-muted mb-1 d-flex align-items-center" >
                    <i class="fas fa-map-marker-alt me-2 mr-1" style="color: {{ $penyedia->color_font ?? '#000000' }};"></i>
                    <span id="alamatToko" class="editable mr-1 editable-nohover" data-field="alamat_toko" style="color: {{ $penyedia->color_font ?? '#000000' }};">{{ $penyedia->alamat_toko }}</span>
                    <i class="fas fa-edit ms-2 text-muted small edit-icon" style="cursor: pointer; color: {{ $penyedia->color_font ?? '#000000' }};" onclick="editField('alamatToko')"></i>
                </p>

                <!-- Rating -->
                <p style="color: {{ $penyedia->color_font ?? '#000000' }};"><strong>Rating:</strong> {{ number_format($penyedia->ulasan->avg('rating'), 1) }} / 5</p>

                <!-- Layanan -->
                <div class="mt-4">
                    <h5 class="fw-semibold mb-0" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">Layanan Tersedia</h5>
                    <p style="color: {{ $penyedia->color_font ?? '#000000' }};">Klik layanan untuk memesan</p>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @forelse($penyedia->layanans as $layanan)
                            <a href="#" class="text-decoration-none m-1">
                                <div class="card shadow-sm border-0 px-3 py-2 text-center" style="min-width: fit-content;">
                                    <span class="fw-semibold text-dark" style="color: {{ $penyedia->color_font ?? '#000000' }};">{{ $layanan->nama_layanan }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="alert alert-warning text-center w-100">
                                <i class="fas fa-exclamation-circle me-2"></i> Penyedia ini belum memiliki layanan.
                            </div>
                        @endforelse

                        <!-- Tombol Plus Tambah Layanan -->
                        <a href="{{ route('layanan.create') }}" class="text-decoration-none m-1">
                            <div class="card shadow-sm border-0 px-3 py-2 text-center d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background-color: #f5f5f5;">
                                <i class="fas fa-plus text-muted"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mt-4 p-3 bg-white rounded shadow-sm">
                    <h5 class="fw-semibold" style="color: {{ $penyedia->color_font_judul ?? '#000000' }};">Tentang Toko <i class="fas fa-edit text-muted small edit-icon" style="cursor: pointer;" onclick="editField('deskripsi')"></i></h5>
                    <p id="deskripsi" class="mt-2 editable editable-nohover" data-field="deskripsi" style="line-height: 1.7; color: {{ $penyedia->color_font ?? '#000000' }};">
                        {!! nl2br(e($penyedia->deskripsi)) !!}
                    </p>

                </div>
            </div>
        </div>
    </div>
    <!-- Pengaturan Warna dan Logo -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3" >
                Edit Warna Toko
            </h5>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
                <!-- Warna Heading -->
                <div class="col d-flex flex-column align-items-start">
                    <label class="small mb-1">Warna Heading</label>
                    <div id="inline_color_heading"
                        class="editable-color-box w-100"
                        data-field="color_heading"
                        style="background-color: {{ $penyedia->color_heading ?? '#bb9587' }};">
                    </div>
                </div>

                <!-- Font Judul -->
                <div class="col d-flex flex-column align-items-start">
                    <label class="small mb-1">Font Judul</label>
                    <div id="inline_color_font_judul"
                        class="editable-color-box w-100"
                        data-field="color_font_judul"
                        style="background-color: {{ $penyedia->color_font_judul ?? '#000000' }};">
                    </div>
                </div>

                <!-- Font Umum -->
                <div class="col d-flex flex-column align-items-start">
                    <label class="small mb-1">Font Umum</label>
                    <div id="inline_color_font"
                        class="editable-color-box w-100"
                        data-field="color_font"
                        style="background-color: {{ $penyedia->color_font ?? '#000000' }};">
                    </div>
                </div>

                <!-- Warna Tombol -->
                <div class="col d-flex flex-column align-items-start">
                    <label class="small mb-1">Warna Thumbnail</label>
                    <div id="inline_color_button"
                        class="editable-color-box w-100"
                        data-field="color_button"
                        style="background-color: {{ $penyedia->color_button ?? '#bb9587' }};">
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-sm btn-outline-secondary" onclick="resetWarnaDefault()">Reset Warna ke Default</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- JavaScript Inline Edit -->
    <script>
    function editField(id) {
        const el = document.getElementById(id);
        const field = el.dataset.field;
        const oldValue = el.innerText.trim().replace(/<br\s*\/?>/g, '\n');

        const input = document.createElement(field === 'deskripsi' ? 'textarea' : 'input');
        input.value = oldValue;
        input.className = 'form-control';

        input.onblur = () => {
            fetch("{{ route('penyedia.inlineUpdate', $penyedia->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ field, value: input.value }),
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    el.innerHTML = input.value.replace(/\n/g, '<br>');
                }
            });
        };

        el.innerHTML = '';
        el.appendChild(input);
        input.focus();
    }

    </script>
    <script>
        function updateMainImage(src, thumb) {
            document.getElementById('mainImage').src = src;

            // Remove border dari semua thumbnail
            document.querySelectorAll('.thumbnail-wrapper').forEach(el => el.classList.remove('border-danger'));

            // Tambahkan border ke yang aktif
            thumb.parentElement.classList.add('border-danger');
        }
    </script>
    <script>
     imageUploader.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            mainImage.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Simpan ke server
        const formData = new FormData();
        formData.append('foto', file);

        fetch("{{ route('penyedia.uploadFoto', $penyedia->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Upload berhasil');
                location.reload(); // reload halaman biar foto baru muncul
            } else {
                console.log('Upload gagal', data);
            }
        })
        .catch(error => console.error('Gagal parsing JSON:', error));
    }
});

    </script>
    <script>

    document.querySelectorAll('.editable-color-box').forEach(box => {
        box.addEventListener('click', function () {
            // Jangan munculkan input kalau sudah ada
            if (this.querySelector('input[type="color"]')) return;

            const field = this.dataset.field;
            const currentColor = window.getComputedStyle(this).backgroundColor;

            const input = document.createElement('input');
            input.type = 'color';
            input.value = rgbToHex(currentColor);
            input.style.width = '100%';
            input.style.height = '100%';
            input.style.border = 'none';
            input.style.padding = '0';
            input.style.background = 'transparent';

            input.addEventListener('input', () => {
                this.style.backgroundColor = input.value; // preview langsung
            });

            input.addEventListener('blur', () => {
                const newColor = input.value;

                fetch("{{ route('penyedia.inlineUpdate', $penyedia->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ field, value: newColor }),
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        this.innerHTML = '';
                        this.style.backgroundColor = newColor;
                        location.reload(); // 🚀 langsung reload setelah update berhasil
                    }
                });
            });


            this.innerHTML = ''; // hapus isi sebelumnya
            this.appendChild(input);
            input.focus();       // langsung fokus
            input.click();       // langsung buka color picker
        });
    });

    function rgbToHex(rgb) {
        const rgbArr = rgb.match(/\d+/g);
        return "#" + rgbArr.map(x => {
            const hex = parseInt(x).toString(16);
            return hex.length === 1 ? "0" + hex : hex;
        }).join('');
    }
</script>


   <script>
    function resetWarnaDefault() {
        const defaultColors = {
            color_heading: '#fdf8f6',
            color_font_judul: '#bb9587',
            color_font: '#000000',
            color_button: '#bb9587',
        };

        Object.entries(defaultColors).forEach(([field, value]) => {
            fetch("{{ route('penyedia.inlineUpdate', $penyedia->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ field, value }),
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const el = document.querySelector(`[data-field="${field}"]`);
                    if (el) el.style.backgroundColor = value;
                }
            });
        });

        // Tunggu sebentar agar semua perubahan tersimpan, lalu reload halaman
        setTimeout(() => location.reload(), 600);
    }
</script>







@endsection
