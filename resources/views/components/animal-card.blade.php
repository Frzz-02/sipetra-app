@props(['pet'])

<div class="col-md-6 col-12 mb-4">
    <div class="card shadow h-100">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <!-- Foto di kiri -->
                <div class="me-3">
                    <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->nama_hewan }}" width="50" height="50" class="rounded-circle border border-dark">
                </div>

                <!-- Info di kanan -->
                <div class="ml-4">
                    <div class="fw-bold text-dark fs-5 text-capitalize mb-1">
                        {{ $pet->nama_hewan }}
                    </div>
                    <div class="text-muted fs-6">
                        {{ $pet->tanggal_lahir }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
