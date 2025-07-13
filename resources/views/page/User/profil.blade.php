@extends('layout.main')

@section('content2')
<div class="py-4" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Foto Profil --}}
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            @php $fotoProfil = Auth::user()->foto_profil; @endphp
                            <img src="{{ $fotoProfil ? asset('storage/foto_profil/' . $fotoProfil) : asset('img/default.png') }}"
                                alt="Foto Profil"
                                class="rounded-circle border"
                                style="width: 130px; height: 130px; object-fit: cover; border: 3px solid #bb9587;">

                            <form id="uploadForm" method="POST" enctype="multipart/form-data" action="{{ route('profil.uploadFoto') }}">
                                @csrf
                                <label for="fotoInput" class="btn btn-sm btn-light shadow position-absolute bottom-0 end-0 mb-1 me-1 rounded-circle"
                                        style="border: 1px solid #bb9587; cursor: pointer;">
                                        <i class="{{ $fotoProfil ? 'fas fa-edit text-secondary' : 'fas fa-plus text-secondary' }}"></i>
                                    </label>
                                <input type="file" name="foto_profil" id="fotoInput" accept="image/*" style="display: none;" onchange="document.getElementById('uploadForm').submit();">
                            </form>
                        </div>
                    </div>

                    {{-- Informasi Utama --}}
                    <div class="mb-3 editable-wrapper d-flex justify-content-center align-items-center">
                        <h3 class="mt-3 text-capitalize fw-bold text-pink mb-0 me-2">
                            <span class="editable" data-field="username">{{ Auth::user()->username }}</span>
                        </h3>
                        <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                    </div>

                    <div class="mb-2 editable-wrapper d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 me-2">
                            <span class="editable" data-field="email">{{ Auth::user()->email }}</span>
                        </p>
                        <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                    </div>

                    <hr style="border-top: 2px solid #bb9587;">

                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted">Tanggal Bergabung</h6>
                            <p class="fw-semibold">{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted">No. Telepon</h6>
                            <div class="editable-wrapper d-flex align-items-center">
                                <p class="fw-semibold mb-0 me-2">
                                    <span class="editable" data-field="no_telephone">{{ Auth::user()->no_telephone ?? 'tidak ada telephone' }}</span>
                                </p>
                                <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h6 class="text-muted">Alamatww</h6>
                            <div class="editable-wrapper d-flex align-items-center">
                                <p class="fw-semibold mb-0 me-2">
                                    <span class="editable" data-field="alamat">{{ Auth::user()->alamat ?? 'tidak ada alamat' }}</span>
                                </p>
                                <i class="fas fa-edit ml-2 edit-icon text-secondary" style="cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard_hewan') }}" class="mt-2 btn btn-outline-secondary px-4 rounded-pill shadow-sm ms-2">Kembali</a>
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
                fetch('{{ route("profil.updateField") }}', {
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
