<div class="col-md-6 col-12 mb-sm-4 mb-2">
    <div class="card border-left-warning shadow h-100">
        <div class="card-body p-2">
            <div class="row align-items-center">

                {{-- Gambar di kiri --}}
                <div class="col-auto d-flex justify-content-center">
                     <img src="{{ asset('assets/hewan/' . $animal_img) }}"
                        alt="{{ $animal_img }}"
                        class="rounded-circle border border-dark"
                        style="width: 48px; height: 48px; object-fit: cover;">
                </div>

                {{-- Nama dan Tanggal Lahir di kanan --}}
                <div class="col pl-2">
                    <div class="font-weight-medium text-warning text-outline text-capitalize mb-1 text-truncate" style="max-width: 100%;">
                        {{ $animal_name }}
                    </div>
                    <div class="h6 font-weight-light text-gray-800 mb-0">
                        {{ $animal_birth }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
