@extends('layouts.landing')

@section('content')
<div class="container py-4 py-md-5 animate__animated animate__fadeIn">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-white p-2 rounded-pill shadow-sm d-inline-flex px-4 border">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none text-muted small"> <i class="bi bi-house-door me-1"></i>Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.tracking.form') }}" class="text-decoration-none text-muted small">Lacak</a></li>
                    <li class="breadcrumb-item active fw-bold text-umb small" aria-current="page">{{ $pengaduan->nomor_tiket }}</li>
                </ol>
            </nav>
            <h2 class="fw-800 text-dark mb-0">Status Laporan</h2>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-light btn-sm rounded-pill px-3 border shadow-sm d-none d-md-block">
                <i class="bi bi-printer me-1"></i> Cetak
            </button>
            <a href="{{ route('pengaduan.tracking.form') }}" class="btn btn-primary-umb btn-sm rounded-pill px-4 shadow-sm">
                Lacak Tiket Lain
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT COLUMN: TIMELINE --}}
        <div class="col-lg-8">
            {{-- TIMELINE CARD --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-umb"></i>Progres Penanganan</h5>
                    
                    {{--  --}}
                    <div class="tracking-timeline">
                        {{-- Step 1: Pending --}}
                        <div class="timeline-item {{ in_array($pengaduan->status, ['pending', 'diproses', 'selesai']) ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="bi bi-file-earmark-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-1">Laporan Diterima</h6>
                                <p class="text-muted small mb-0">Laporan Anda telah masuk ke sistem dan menunggu verifikasi admin.</p>
                                <span class="badge bg-light text-muted mt-2 border small fw-normal">{{ $pengaduan->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        {{-- Step 2: Proses --}}
                        <div class="timeline-item {{ in_array($pengaduan->status, ['diproses', 'selesai']) ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="bi bi-gear-wide-connected"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-1">Sedang Diproses</h6>
                                <p class="text-muted small mb-0">Tim sarana prasarana sedang meninjau lokasi atau menyiapkan material perbaikan.</p>
                                @if($pengaduan->status == 'diproses')
                                    <span class="badge bg-primary-subtle text-primary mt-2 border border-primary-subtle small fw-bold">Update Terkini</span>
                                @endif
                            </div>
                        </div>

                        {{-- Step 3: Selesai --}}
                        <div class="timeline-item {{ $pengaduan->status == 'selesai' ? 'active success' : '' }}">
                            <div class="timeline-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="timeline-content border-0 pb-0">
                                <h6 class="fw-bold mb-1">Selesai</h6>
                                <p class="text-muted small mb-0">Laporan telah diselesaikan. Terima kasih telah menjaga fasilitas UMB.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DESCRIPTION CARD --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-umb"></i>Rincian Laporan</h5>
                    <div class="p-4 bg-light rounded-4 border border-dashed border-2">
                        <h6 class="fw-bold text-dark">{{ $pengaduan->judul }}</h6>
                        <hr class="my-3 opacity-10">
                        <p class="text-muted mb-0 lh-lg" style="font-size: 0.95rem;">
                            {{ $pengaduan->deskripsi }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: DETAILS & PHOTO --}}
        <div class="col-lg-4">
            {{-- DATA CARD --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Tiket</h6>
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <small class="text-muted d-block">Nomor Tiket</small>
                            <span class="fw-bold text-umb">{{ $pengaduan->nomor_tiket }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Kategori</small>
                            <span class="fw-semibold">{{ $pengaduan->category->title }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Pelapor (NIM)</small>
                            <span class="fw-semibold text-dark">{{ substr($pengaduan->nim, 0, 4) }}****</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ATTACHMENT CARD --}}
            @if ($pengaduan->foto)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-3 border-bottom">
                        <h6 class="fw-bold mb-0">Lampiran Foto</h6>
                    </div>
                    <img src="{{ asset('storage/'.$pengaduan->foto) }}" 
                         class="img-fluid w-100" 
                         style="max-height: 300px; object-fit: cover;"
                         alt="Bukti Laporan">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    
    /* Modern Timeline CSS */
    .tracking-timeline {
        padding-left: 1rem;
        position: relative;
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        padding-bottom: 2.5rem;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 45px;
        height: 45px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        color: #94a3b8;
        transition: 0.3s;
    }

    .timeline-item::before {
        content: "";
        position: absolute;
        left: 21.5px;
        top: 45px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .timeline-item.active .timeline-icon {
        background: var(--umb-blue);
        color: white;
        border-color: var(--umb-blue);
        box-shadow: 0 0 0 5px rgba(11, 78, 162, 0.1);
    }

    .timeline-item.active::before {
        background: var(--umb-blue);
    }

    .timeline-item.success.active .timeline-icon {
        background: #10b981;
        border-color: #10b981;
    }

    .timeline-item.success.active::before {
        display: none;
    }

    /* Mobile Optimization */
    @media (max-width: 768px) {
        .timeline-item { padding-left: 2.5rem; padding-bottom: 2rem; }
        .timeline-icon { width: 35px; height: 35px; left: 5px; }
        .timeline-icon i { font-size: 0.8rem; }
        .timeline-item::before { left: 21.5px; }
    }
</style>
@endsection