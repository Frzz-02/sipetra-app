@extends('layout.main')

@section('content2')
<div class="py-4" style="max-height: calc(100vh - 100px); overflow-y: scroll; scrollbar-width: none; -ms-overflow-style: none;">
    <style>
        .container::-webkit-scrollbar {
            display: none;
        }

        .clickable-row {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .clickable-row:hover {
            background-color: #f8f9fa;
        }

        @media (max-width: 576px) {
            .table td, .table th {
                font-size: 0.875rem;
            }
        }
    </style>

    <h3 class="mb-3">Riwayat Pesanan</h3>
   <div id="statusFilters" class="d-flex overflow-auto mb-4" style="gap: 0.5rem;">
        @php
            $statuses = [
                'semua' => ['label' => 'Semua', 'class' => 'bg-light text-dark border-secondary'],
                'menunggu pembayaran' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-dark text-white border-dark'],
                'menunggu diproses' => ['label' => 'Menunggu Diproses', 'class' => 'bg-warning text-dark border-warning'],
                'diproses' => ['label' => 'Diproses', 'class' => 'bg-info text-white border-info'],
                'selesai' => ['label' => 'Selesai', 'class' => 'bg-success text-white border-success'],
                'batal' => ['label' => 'Batal', 'class' => 'bg-danger text-white border-danger'],
            ];
        @endphp


       @foreach ($statuses as $key => $data)
            <div class="px-3 py-2 rounded-pill filter-item mb-2 {{ $data['class'] }}"
                data-status="{{ $key }}"
                style="cursor: pointer; white-space: nowrap; flex: 0 0 auto; border: 2px solid;"
                >
                {{ $data['label'] }}
            </div>
        @endforeach


    </div>



    @if($pesanans->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat pesanan.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Layanan & Tanggal</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $pesanan)
                        @php
                            $link = $pesanan->status === 'menunggu pembayaran'
                                ? route('pembayaran.lanjutkan', $pesanan->id)
                                : route('pesanan.detail', $pesanan->id); // Ganti jika route detail berbeda
                        @endphp
                      <tr class="clickable-row" data-status="{{ strtolower($pesanan->status) }}" onclick="window.location='{{ $link }}'">
                            <td>
                                <div class="d-flex flex-column">
                                    <strong>
                                          {{ $pesanan->layanan->nama_layanan ?? '-' }}
                                    </strong>
                                    <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</span>
                                     <div class="d-inline-block">
                                        <span class="badge mt-1 w-auto d-inline-block
                                            @switch($pesanan->status)
                                                @case('menunggu pembayaran') bg-dark text-white @break
                                                @case('menunggu diproses') bg-warning text-dark @break
                                                @case('diproses') bg-info text-white @break
                                                @case('selesai') bg-success text-white @break
                                                @case('batal') bg-danger text-white @break
                                                @default bg-light text-dark
                                            @endswitch
                                        ">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                     </div>
                                </div>
                            </td>
                            <td class="align-middle">Rp {{ number_format($pesanan->total_biaya) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterItems = document.querySelectorAll(".filter-item");
        const rows = document.querySelectorAll(".clickable-row");

        filterItems.forEach(item => {
            item.addEventListener("click", function () {
                const selected = this.getAttribute("data-status");

                // Highlight aktif
                filterItems.forEach(i => i.classList.remove("bg-primary", "text-white"));
                this.classList.add("bg-primary", "text-white");

                rows.forEach(row => {
                    const rowStatus = row.getAttribute("data-status");
                    if (selected === "semua" || rowStatus === selected) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    });
</script>

@endsection
