@extends('layouts.landing')

@section('content')
{{-- Background Overlay (Opsional untuk estetika) --}}
<div class="position-absolute top-0 start-0 w-100 h-25 bg-primary opacity-5 d-none d-lg-block" style="z-index: -1;"></div>

<div class="container py-4 py-md-5 animate__animated animate__fadeIn">

    {{-- ================= BREADCRUMB ================= --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-2 rounded-pill shadow-sm d-inline-flex px-4 border">
            <li class="breadcrumb-item">
                <a href="{{ route('landing') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-house-door me-1"></i> Beranda
                </a>
            </li>
            <li class="breadcrumb-item active fw-bold text-umb small" aria-current="page">Kategori Pengaduan</li>
        </ol>
    </nav>

    {{-- ================= HEADER ================= --}}
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-bold">
                <i class="bi bi-grid-fill me-2"></i>Layanan Aspirasi
            </span>
            <h2 class="fw-800 display-6 text-dark">Apa yang Ingin Anda <span class="text-umb">Laporkan?</span></h2>
            <p class="text-muted fs-6 px-md-5">
                Pilih kategori yang sesuai agar tim sarana prasarana dapat melakukan validasi dan perbaikan dengan lebih akurat.
            </p>
        </div>
    </div>

    {{-- ================= CATEGORY GRID ================= --}}
    <div class="row g-3 g-md-4 justify-content-center">
        @foreach ($categories as $cat)
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ url('/pengaduan/'.$cat->id) }}" class="text-decoration-none h-100 d-block group-card">
                <div class="card border-0 shadow-sm h-100 overflow-hidden transition-all rounded-4">
                    <div class="card-body p-4 p-md-5 text-center">
                        
                        {{-- Decorative Circle behind Icon --}}
                        <div class="icon-container position-relative mb-4">
                            <div class="icon-circle mx-auto d-flex align-items-center justify-content-center shadow-sm">
                                <i class="bi bi-{{ $cat->icon }} display-6"></i>
                            </div>
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ $cat->title }}</h5>
                        <p class="text-muted small lh-base mb-4">
                            {{ $cat->desc }}
                        </p>

                        <div class="cta-wrapper">
                            <div class="btn btn-light text-primary fw-bold rounded-pill px-4 btn-sm shadow-sm border py-2">
                                Pilih <i class="bi bi-arrow-right ms-1 transition-all"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Visual Accent on bottom --}}
                    <div class="accent-bar bg-umb"></div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- ================= INFO FOOTER (HP View Optimised) ================= --}}
    <div class="mt-5 text-center p-4 bg-white rounded-4 border shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
        <div class="d-flex align-items-center justify-content-center flex-column flex-md-row gap-3">
            <div class="bg-warning-subtle text-warning p-3 rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-lightbulb fs-4"></i>
            </div>
            <div class="text-md-start">
                <h6 class="fw-bold mb-1">Kategori tidak ditemukan?</h6>
                <p class="text-muted small mb-0">Jika masalah Anda tidak masuk ke dalam kategori di atas, silakan hubungi Pusat Bantuan IT.</p>
            </div>
        </div>
    </div>
</div>

{{-- ================= CUSTOM CSS FOR REFINEMENT ================= --}}
<style>
    .fw-800 { font-weight: 800; }
    
    /* Card Professional Styling */
    .card {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.02) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .group-card:hover .card {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(11, 78, 162, 0.12) !important;
        border-color: var(--umb-blue) !important;
    }

    /* Icon Container */
    .icon-circle {
        width: 80px;
        height: 80px;
        background: var(--soft-blue);
        color: var(--umb-blue);
        border-radius: 24px;
        transition: 0.3s;
    }

    .group-card:hover .icon-circle {
        background: var(--umb-blue);
        color: #fff;
        transform: rotate(-5deg) scale(1.1);
    }

    /* Accent Bar Animation */
    .accent-bar {
        height: 4px;
        width: 0;
        transition: 0.4s ease;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .group-card:hover .accent-bar {
        width: 100%;
    }

    /* Hover arrow interaction */
    .group-card:hover .bi-arrow-right {
        margin-left: 8px !important;
    }

    /* Mobile Adjustments */
    @media (max-width: 576px) {
        .icon-circle { width: 65px; height: 65px; }
        .icon-circle i { font-size: 1.8rem; }
        .card-body { padding: 30px 20px !important; }
        .display-6 { font-size: 1.75rem; }
    }
</style>
@endsection