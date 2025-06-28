@props(['pet'])
<div class="col-md-6 col-12 mb-sm-4 mb-2">
    <div class="card border-left-warning shadow h-100">
        <div class="card-body p-2">
            <div class="row no-gutters align-items-center d-flex flex-row-reverse pr-1">
              
                <div class="col-xl-10 col-8 col-sm-10 col-md-9 pl-2">
                    <div class="font-weight-medium text-warning text-outline text-capitalize mb-0 p-0 text-truncate" style="max-width: 100%">
                        {{ $pet->nama_hewan }}
                    </div>
                    <div class="h5 font-weight-light fs-3 mb-1 text-gray-800">{{ $pet->tanggal_lahir }}</div>
                </div>

                <div class="col">
                  <div class="d-flex justify-content-center">
                    <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->nama_hewan }}" class="img-size img-size-max rounded-circle border border-dark border-1">
                    {{-- width="47" height="47" --}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
