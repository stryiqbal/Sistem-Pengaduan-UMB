@extends('layouts.landing')

@section('content')
<div class="container py-4 py-md-5">

    {{-- HEADER & ACTION --}}
    <div class="row align-items-center mb-5 g-3">
        <div class="col-md-8">
            <h2 class="fw-800 display-6 mb-1 text-dark">Layanan <span class="text-primary-umb">Transparansi</span></h2>
            <p class="text-muted fs-6 mb-0">Pantau progres perbaikan fasilitas kampus secara real-time dan terbuka.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('pengaduan.tracking.form') }}" class="btn btn-primary-umb shadow-sm px-4 py-2 rounded-pill fw-semibold">
                <i class="bi bi-search me-2"></i>Lacak Tiket
            </a>
        </div>
    </div>

    {{-- FILTER BOX (DESKTOP & MOBILE) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden border-start border-primary-umb border-5">
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group border rounded-pill px-3 py-1 bg-white">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="globalSearch" class="form-control border-0 shadow-none bg-transparent" placeholder="Cari nomor tiket atau judul laporan...">
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
                        @foreach ($pengaduan->pluck('category.title')->unique() as $cat)
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
            <table class="table table-hover align-middle mb-0" id="userPengaduanTable" style="width: 100%">
                <thead class="bg-light-subtle border-bottom">
                    <tr>
                        <th class="py-3 ps-4 text-muted small fw-bold">TIKET</th>
                        <th class="py-3 text-muted small fw-bold">JUDUL PENGADUAN</th>
                        <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                        <th class="py-3 text-muted small fw-bold text-center">TANGGAL</th>
                        <th class="py-3 pe-4 text-end text-muted small fw-bold">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduan as $item)
                    <tr class="table-row-hover" data-id="{{ $item->id }}">
                        <td class="ps-4">
                            <span class="fw-bold text-primary-umb">{{ $item->nomor_tiket }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ Str::limit($item->judul, 50) }}</div>
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="bi bi-tag small"></i> <span class="badge-cat">{{ $item->category->title }}</span>
                            </small>
                        </td>
                        <td class="text-center">
                            @php
                                $statusStyle = match($item->status) {
                                    'pending' => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#bae6fd', 'icon' => '⏳ Pending'],
                                    'diproses' => ['bg' => '#38bdf8', 'color' => '#ffffff', 'border' => '#0ea5e9', 'icon' => '🔧 Proses'],
                                    'selesai' => ['bg' => '#1e40af', 'color' => '#ffffff', 'border' => '#1e3a8a', 'icon' => '✅ Selesai'],
                                    default => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#bae6fd', 'icon' => '⏳ Pending'],
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }}; border: 1px solid {{ $statusStyle['border'] }}; font-weight: 600;">
                                {{ $statusStyle['icon'] }}
                            </span>
                            <span class="d-none">{{ $item->status }}</span>
                        </td>
                        <td class="text-center text-muted small">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-outline-primary-umb rounded-pill px-3 shadow-none">
                                Detail
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
        @foreach ($pengaduan as $item)
            <div class="card border-0 shadow-sm rounded-4 mb-3 mobile-card border-bottom border-4 border-light" 
                 data-title="{{ strtolower($item->judul) }}"
                 data-ticket="{{ strtolower($item->nomor_tiket) }}" 
                 data-status="{{ $item->status }}"
                 data-category="{{ strtolower($item->category->title) }}">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-light text-primary-umb border border-primary-subtle px-2 py-1">{{ $item->nomor_tiket }}</span>
                        <small class="text-muted fw-semibold"><i class="bi bi-calendar3 me-1"></i> {{ $item->created_at->format('d/m/y') }}</small>
                    </div>
                    <h6 class="fw-800 text-dark mb-2">{{ Str::limit($item->judul, 65) }}</h6>
                    <div class="mb-3">
                        <span class="text-muted small"><i class="bi bi-bookmark me-1"></i> {{ $item->category->title }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="status-indicator">
                            @php
                                $sMob = match($item->status) {
                                    'pending' => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#bae6fd', 'icon' => '⏳ Pending'],
                                    'diproses' => ['bg' => '#38bdf8', 'color' => '#ffffff', 'border' => '#0ea5e9', 'icon' => '🔧 Proses'],
                                    'selesai' => ['bg' => '#1e40af', 'color' => '#ffffff', 'border' => '#1e3a8a', 'icon' => '✅ Selesai'],
                                    default => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#bae6fd', 'icon' => '⏳ Pending'],
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2" 
                                  style="background-color: {{ $sMob['bg'] }}; color: {{ $sMob['color'] }}; border: 1px solid {{ $sMob['border'] }}; font-weight: 600; font-size: 0.75rem;">
                                {{ $sMob['icon'] }}
                            </span>
                        </div>
                        <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-primary-umb rounded-pill px-4">
                            Detail <i class="bi bi-arrow-right ms-1"></i>
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

    /* DataTables Pagination Styling */
    .dataTables_wrapper .pagination { padding: 20px; justify-content: flex-end; }
    .page-link { border: none; background: #f8f9fa; margin: 0 2px; border-radius: 8px !important; color: #0b4ea2; }
    .page-item.active .page-link { background: #0b4ea2 !important; color: white !important; }
    .dataTables_info { padding: 20px; font-size: 0.85rem; color: #6c757d; }
    .dataTables_filter, .dataTables_length { display: none; }
</style>

@push('scripts')
{{-- Pastikan jQuery dan DataTables JS sudah ada di layout landing --}}
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    const table = $('#userPengaduanTable').DataTable({
        "dom": 'rtip',
        "pageLength": 10,
        "language": {
            "paginate": {
                "previous": "<i class='bi bi-chevron-left'></i>",
                "next": "<i class='bi bi-chevron-right'></i>"
            },
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ laporan",
            "emptyTable": "Belum ada laporan yang tersedia"
        },
        "order": [[ 3, "desc" ]], // Urutkan berdasarkan tanggal terbaru
        "columnDefs": [
            { "orderable": false, "targets": 4 }
        ]
    });

    // 2. Fungsi Filter Gabungan (Desktop & Mobile)
    function applyAllFilters() {
        const query = $('#globalSearch').val().toLowerCase();
        const status = $('#filterStatus').val();
        const category = $('#filterKategori').val();

        // Apply ke DataTables (Desktop)
        table.search(query);
        table.column(2).search(status);
        table.column(1).search(category);
        table.draw();

        // Apply ke Cards (Mobile)
        $('.mobile-card').each(function() {
            const matchSearch = $(this).data('title').includes(query) || $(this).data('ticket').includes(query);
            const matchStatus = !status || $(this).data('status') === status;
            const matchCat = !category || $(this).data('category').includes(category.toLowerCase());
            
            $(this).toggle(matchSearch && matchStatus && matchCat);
        });
    }

    // Listener Input
    $('#globalSearch').on('keyup', applyAllFilters);
    $('#filterStatus, #filterKategori').on('change', applyAllFilters);

    // 3. Row Click Redirect
    $('#userPengaduanTable tbody').on('click', 'tr', function (e) {
        if ($(e.target).closest('a').length) return;
        const id = $(this).data('id');
        if(id) window.location.href = `/pengaduan/${id}`;
    });
});
</script>
@endpush
@endsection