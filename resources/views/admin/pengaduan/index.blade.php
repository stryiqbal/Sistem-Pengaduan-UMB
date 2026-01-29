@extends('layouts.admin')

@section('title', 'Layanan Transparansi - Admin')
@section('page-title', 'Layanan Transparansi')

@section('content')
<div class="container py-4 py-md-5">

    {{-- HEADER --}}
    <div class="row align-items-center mb-5 g-3">
        <div class="col-md-8">
            <h2 class="fw-800 display-6 mb-1 text-dark">Panel <span class="text-primary-umb">Administrator</span></h2>
            <p class="text-muted fs-6 mb-0">Monitoring dan kelola laporan perbaikan fasilitas secara sistematis.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-primary-umb shadow-sm px-4 py-2 rounded-pill fw-semibold">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Ekspor Laporan
            </button>
        </div>
    </div>

    {{-- FILTER BOX --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden border-start border-primary-umb border-5">
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group border rounded-pill px-3 py-1 bg-white">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="globalSearch" class="form-control border-0 shadow-none bg-transparent" placeholder="Cari nama, tiket, atau NIM...">
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <select id="filterStatus" class="form-select border-pill shadow-none">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-lg-3 col-6">
                    <select id="filterKategori" class="form-select border-pill shadow-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($pengaduans->pluck('kategori')->unique() as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="pengaduanTable" style="width: 100%">
                <thead class="bg-light-subtle border-bottom">
                    <tr>
                        <th class="py-3 ps-4 text-muted small fw-bold">TIKET</th>
                        <th class="py-3 text-muted small fw-bold">MAHASISWA & KATEGORI</th>
                        <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                        <th class="py-3 text-muted small fw-bold text-center">TANGGAL</th>
                        <th class="py-3 pe-4 text-end text-muted small fw-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduans as $p)
                    <tr class="table-row-hover" data-id="{{ $p->id }}">
                        <td class="ps-4">
                            <span class="fw-bold text-primary-umb">{{ $p->nomor_tiket }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm d-flex align-items-center justify-content-center rounded-circle me-3 fw-bold shadow-sm" 
                                     style="width:35px; height:35px; background: #f0f5ff; color: #0b4ea2; font-size: 12px; border: 1px solid #e2e8f0;">
                                    {{ strtoupper(substr($p->nama_mahasiswa,0,1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $p->nama_mahasiswa }}</div>
                                    <small class="text-muted">{{ $p->nim }} • <span class="badge-cat">{{ $p->kategori }}</span></small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $statusLabel = match($p->status) {
                                    'pending' => ['class' => 'badge-pending', 'icon' => '⏳ Pending'],
                                    'diproses' => ['class' => 'badge-proses', 'icon' => '🔧 Proses'],
                                    'selesai' => ['class' => 'badge-selesai', 'icon' => '✅ Selesai'],
                                    default => ['class' => 'badge-pending', 'icon' => '⏳ Pending'],
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 {{ $statusLabel['class'] }}">
                                {{ $statusLabel['icon'] }}
                            </span>
                            <span class="d-none">{{ $p->status }}</span> {{-- Hidden text untuk filter DataTables --}}
                        </td>
                        <td class="text-center text-muted small">
                            {{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-sm btn-outline-primary-umb rounded-pill px-3 shadow-none">
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MOBILE CARD LIST --}}
    <div class="d-md-none" id="mobileContainer">
        @foreach ($pengaduans as $p)
            <div class="card border-0 shadow-sm rounded-4 mb-3 admin-mobile-card border-bottom border-4 border-light" 
                 data-name="{{ strtolower($p->nama_mahasiswa) }}"
                 data-ticket="{{ strtolower($p->nomor_tiket) }}" 
                 data-status="{{ $p->status }}"
                 data-category="{{ strtolower($p->kategori) }}">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-light text-primary-umb border border-primary-subtle px-2 py-1">{{ $p->nomor_tiket }}</span>
                        <small class="text-muted fw-semibold">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/y') }}</small>
                    </div>
                    <h6 class="fw-800 text-dark mb-1">{{ $p->nama_mahasiswa }}</h6>
                    <div class="mb-3 small text-muted">
                        {{ $p->nim }} • <i class="bi bi-tag"></i> {{ $p->kategori }}
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        @php
                            $statusMob = match($p->status) {
                                'pending' => ['class' => 'badge-pending', 'icon' => '⏳ Pending'],
                                'diproses' => ['class' => 'badge-proses', 'icon' => '🔧 Proses'],
                                'selesai' => ['class' => 'badge-selesai', 'icon' => '✅ Selesai'],
                                default => ['class' => 'badge-pending', 'icon' => '⏳ Pending'],
                            };
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 {{ $statusMob['class'] }}" style="font-size: 0.7rem;">
                            {{ $statusMob['icon'] }}
                        </span>
                        <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-sm btn-primary-umb rounded-pill px-4">
                            Kelola <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .border-pill { border-radius: 50px !important; }
    .table-row-hover { transition: background 0.2s; cursor: pointer; }
    .table-row-hover:hover { background-color: #f8f9ff; }
    
    .text-primary-umb { color: #0b4ea2; }
    .btn-primary-umb { background-color: #0b4ea2; border-color: #0b4ea2; color: white; }
    .btn-primary-umb:hover { background-color: #083b7a; border-color: #083b7a; color: white; }
    .btn-outline-primary-umb { color: #0b4ea2; border-color: #0b4ea2; }
    .btn-outline-primary-umb:hover { background-color: #0b4ea2; color: white; }
    .border-primary-umb { border-color: #0b4ea2 !important; }

    /* Badge Custom Styles */
    .badge-pending { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 600; }
    .badge-proses  { background-color: #38bdf8; color: #ffffff; border: 1px solid #0ea5e9; font-weight: 600; }
    .badge-selesai { background-color: #1e40af; color: #ffffff; border: 1px solid #1e3a8a; font-weight: 600; }

    /* DataTables Custom UI */
    .dataTables_wrapper .pagination { padding: 20px; justify-content: flex-end; }
    .page-link { border: none; background: #f8f9fa; margin: 0 2px; border-radius: 8px !important; color: #0b4ea2; }
    .page-item.active .page-link { background: #0b4ea2 !important; color: white !important; }
    .dataTables_info { padding: 20px; font-size: 0.85rem; color: #6c757d; }
    .dataTables_filter { display: none; } /* Sembunyikan search bawaan */
    .dataTables_length { display: none; }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    const table = $('#pengaduanTable').DataTable({
        "dom": 'rtip',
        "pageLength": 10,
        "language": {
            "paginate": {
                "previous": "<i class='bi bi-chevron-left'></i>",
                "next": "<i class='bi bi-chevron-right'></i>"
            },
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ laporan",
            "emptyTable": "Tidak ada data yang tersedia"
        },
        "columnDefs": [
            { "orderable": false, "targets": 4 }
        ]
    });

    // 2. Fungsi Filter Desktop
    $('#globalSearch').on('keyup', function() {
        table.search(this.value).draw();
        syncMobile();
    });

    $('#filterStatus').on('change', function() {
        table.column(2).search(this.value).draw();
        syncMobile();
    });

    $('#filterKategori').on('change', function() {
        table.column(1).search(this.value).draw();
        syncMobile();
    });

    // 3. Fungsi Filter Mobile (Sync dengan input yang sama)
    function syncMobile() {
        const query = $('#globalSearch').val().toLowerCase();
        const status = $('#filterStatus').val().toLowerCase();
        const category = $('#filterKategori').val().toLowerCase();

        $('.admin-mobile-card').each(function() {
            const textMatch = $(this).data('name').includes(query) || $(this).data('ticket').includes(query);
            const statusMatch = !status || $(this).data('status') === status;
            const catMatch = !category || $(this).data('category').includes(category);

            $(this).toggle(textMatch && statusMatch && catMatch);
        });
    }

    // 4. Baris tabel bisa diklik
    $('#pengaduanTable tbody').on('click', 'tr', function (e) {
        if ($(e.target).closest('a').length) return; // Jangan redirect jika klik tombol 'Kelola'
        const id = $(this).data('id');
        if(id) window.location.href = `/admin/pengaduan/${id}`;
    });
});
</script>
@endpush
@endsection