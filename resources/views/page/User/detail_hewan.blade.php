@extends('layout.main')

@section('content2')
<div class="py-4" style="
    max-height: calc(100vh - 100px);
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
    overflow-x: hidden;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Foto Hewan --}}
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block mb-4">
                          <img src="{{ asset('storage/foto_hewan/' . $hewan->foto_hewan) }}"
                                alt="{{ $hewan->foto_hewan }}"
                                class="rounded-circle border border-dark shadow"
                                style="width: 130px; height: 130px; object-fit: cover;">

                            <form id="uploadFotoHewanForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('hewan.uploadFoto', ['id' => $hewan->id]) }}">
                                @csrf
                                <label for="fotoHewanInput" class="btn btn-sm btn-light shadow position-absolute bottom-0 end-0 mb-1 me-1 rounded-circle"
                                    style="border: 1px solid #bb9587; cursor: pointer;">
                                    <i class="fas fa-edit text-secondary"></i>
                                </label>
                                <input type="file" name="foto_hewan" id="fotoHewanInput" accept="image/*"
                                    style="display: none;" onchange="document.getElementById('uploadFotoHewanForm').submit();">
                            </form>
                        </div>

                        {{-- Nama dan Jenis --}}
                        <h3 class="mt-3 text-capitalize text-primary fw-bold editable-wrapper d-flex justify-content-center align-items-center">
                            <span class="editable" data-field="nama_hewan">{{ $hewan->nama_hewan }}</span>
                            <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                        </h3>
                        <p class="text-muted editable-wrapper d-flex justify-content-center align-items-center">
                            <span class="editable" data-field="jenis_hewan">{{ $hewan->jenis_hewan }}</span>
                            <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                        </p>
                    </div>


                    <hr>

                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Tanggal Lahir</h6>
                            <p class="fw-semibold">{{ \Carbon\Carbon::parse($hewan->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Umur</h6>
                            <p class="fw-semibold">{{ $hewan->umur ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Berat</h6>
                            <p class="fw-semibold editable-wrapper d-flex align-items-center">
                                <span class="editable" data-field="berat">{{ $hewan->berat ?? '-' }}</span>
                                <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                            </p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">Pemilik</h6>
                            <p class="fw-semibold">{{ $hewan->user->username ?? 'Tidak Diketahui' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Deskripsi</h6>
                        <p class="fw-semibold editable-wrapper d-flex align-items-center">
                            <span class="editable" data-field="deskripsi">{{ $hewan->deskripsi ?? '-' }}</span>
                            <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard_hewan') }}" class="mt-2 btn btn-secondary px-4 rounded-pill shadow-sm ms-2">Kembali</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Inline Edit Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editable-wrapper').forEach(wrapper => {
        const span = wrapper.querySelector('.editable');
        const icon = wrapper.querySelector('.edit-icon');

        function activateEdit() {
            if (wrapper.querySelector('input')) return;

            const oldText = span.textContent.trim();
            const field = span.dataset.field;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = oldText;
            input.className = 'form-control form-control-sm';
            input.style.maxWidth = '300px';

            span.innerHTML = '';
            span.appendChild(input);
            icon.style.display = 'none';
            input.focus();

            input.addEventListener('blur', () => {
                fetch('{{ route("hewan.updateField", ["id" => $hewan->id]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ field, value: input.value })
                })
                .then(res => res.json())
                .then(data => {
                    span.innerHTML = data.new_value;
                    icon.style.display = 'inline';
                })
                .catch(() => {
                    span.innerHTML = oldText;
                    icon.style.display = 'inline';
                });
            });
        }

        icon.addEventListener('click', activateEdit);
        span.addEventListener('click', activateEdit);
    });
});
</script>
@endsection
