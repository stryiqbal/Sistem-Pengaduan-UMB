@extends('layouts.landing')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    
    {{-- Decorative Background Glows (Hanya Desktop) --}}
    <div class="position-absolute top-50 start-50 translate-middle w-75 h-50 bg-primary opacity-5 blur-60 d-none d-md-block"></div>

    <div class="card border-0 shadow-2xl p-4 p-md-5 text-center position-relative animate__animated animate__zoomIn"
         style="max-width: 500px; border-radius: 32px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">

        {{-- SEARCH ICON WITH RING ANIMATION --}}
        <div class="search-icon-wrapper mb-4">
            <div class="search-circle mx-auto d-flex align-items-center justify-content-center shadow-lg">
                <i class="bi bi-search text-white fs-1"></i>
            </div>
        </div>

        {{-- TEXT HEADER --}}
        <div class="mb-4">
            <h2 class="fw-800 text-dark mb-2">Lacak Laporan</h2>
            <p class="text-muted px-md-4">Gunakan nomor tiket resmi Anda untuk memantau sejauh mana penanganan pengaduan dilakukan.</p>
        </div>

        {{-- ALERT ERROR --}}
        @if (session('error'))
            <div class="alert alert-danger border-0 rounded-4 animate__animated animate__shakeX mb-4 d-flex align-items-center gap-2 text-start">
                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                <span class="small fw-semibold">{{ session('error') }}</span>
            </div>
        @endif

        {{-- TRACKING FORM --}}
        <form action="{{ route('pengaduan.tracking.result') }}" method="POST" class="mt-2">
            @csrf

            <div class="input-modern-group mb-4">
                <label class="small fw-bold text-umb mb-2 d-block text-start ms-2">Nomor Tiket Pengaduan</label>
                <div class="position-relative">
                    <input
                        type="text"
                        name="nomor_tiket"
                        class="form-control form-control-xl text-center fw-bold tracking-input"
                        placeholder="Contoh: PGD-20260122-0001"
                        style="letter-spacing: 1px;"
                        required
                    >
                    <i class="bi bi-hash position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-4 d-none d-md-block"></i>
                </div>
                <div class="mt-2 d-flex align-items-center justify-content-center gap-2 text-muted small">
                    <i class="bi bi-info-circle"></i>
                    <span>Perhatikan tanda hubung (-) dan angka</span>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary-umb btn-modern py-3 rounded-pill fs-6 shadow-primary">
                    <i class="bi bi-search me-2"></i> Periksa Status Sekarang
                </button>
            </div>
        </form>

        {{-- QUICK LINKS --}}
        <div class="mt-5 pt-3 border-top border-light">
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="{{ route('landing') }}" class="text-decoration-none text-muted small hover-umb transition-all">
                    <i class="bi bi-house me-1"></i> Beranda
                </a>
                <span class="text-light d-none d-md-block">|</span>
                <a href="{{ route('pengaduan.index') }}" class="text-decoration-none text-muted small hover-umb transition-all">
                    <i class="bi bi-journal-text me-1"></i> Lihat Semua Laporan
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .blur-60 { filter: blur(80px); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); }
    .shadow-primary { box-shadow: 0 8px 20px rgba(11, 78, 162, 0.25); }
    
    /* Animated Search Icon */
    .search-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--umb-blue), #4a90e2);
        border-radius: 30px;
        transform: rotate(-10deg);
        transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card:hover .search-circle {
        transform: rotate(0deg) scale(1.05);
    }

    /* Input Styling */
    .tracking-input {
        height: 65px;
        border: 2px solid #e2e8f0;
        border-radius: 18px;
        font-size: 1.1rem;
        transition: all 0.3s;
        background: #f8fafc;
    }
    .tracking-input:focus {
        border-color: var(--umb-blue);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(11, 78, 162, 0.1);
        transform: translateY(-2px);
    }

    .hover-umb:hover { color: var(--umb-blue) !important; }
    .transition-all { transition: all 0.3s; }

    /* Mobile Optimization */
    @media (max-width: 576px) {
        .card { border-radius: 0; min-height: 100vh; width: 100%; padding: 40px 20px !important; }
        .search-circle { width: 80px; height: 80px; border-radius: 24px; }
        .tracking-input { font-size: 1rem; height: 60px; }
        .btn-modern { padding: 16px !important; }
    }
</style>
@endsection