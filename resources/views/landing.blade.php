@extends('layouts.landing')

@section('content')
<section class="min-vh-100 d-flex align-items-stretch overflow-hidden">

    {{-- ================= MOBILE VIEW (Immersive) ================= --}}
    <div class="d-md-none w-100 d-flex align-items-center text-white text-center"
        style="min-height: 100vh; background: linear-gradient(rgba(11,78, 162, 0.4), rgba(0, 0, 0, 0.1)), url('{{ asset('images/umb.jpeg') }}') center / cover no-repeat;">
        
        <div class="container px-4 animate__animated animate__fadeIn">
            {{-- Badge dengan Biru UMB Transparan --}}
            <div class="mb-4">
                <span class="badge rounded-pill px-3 py-2" style="background: #0B4EA2; backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.3);">
                    🏛️ Official Campus Portal
                </span>
            </div>

            {{-- Judul dengan aksen warna disesuaikan --}}
            <h1 class="fw-bolder lh-sm display-5 mb-3">
                Layanan Aspirasi & Pengaduan Fasilitas
            </h1>

            <p class="mt-3 text-white opacity-100 fs-6 fw-light">
                Sampaikan keluhan fasilitas kampus Universitas Muhammadiyah Bandung secara digital, transparan, dan terintegrasi.
            </p>

            {{-- Tombol yang Dipersempit --}}
            <div class="d-grid gap-2 mt-5 mx-auto" style="max-width: 280px;">
                <a href="{{ route('fasilitas.index') }}" class="btn btn-umb px-5 py-3 rounded-pill shadow-lg fw-bold transition-up">
                    Buat Laporan <i class="bi bi-plus-lg ms-2"></i>
                </a>
                
                <a href="{{ route('pengaduan.index') }}" 
                class="btn btn-light py-3 rounded-pill fw-bold shadow-sm" 
                style="border: 1px solid #ffffff;">
                    <i class="bi bi-search me-2"></i> Cek Status
                </a>
            </div>
        </div>
    </div>

    {{-- ================= DESKTOP VIEW (Professional Split) ================= --}}
    <div class="container-fluid d-none d-md-flex p-0">
        <div class="row g-0 w-100">

            {{-- LEFT CONTENT --}}
            <div class="col-md-6 d-flex align-items-center bg-white shadow-lg" style="z-index: 10;">
                <div class="p-5 p-lg-5 w-100 animate__animated animate__slideInLeft">
                    <div class="ps-lg-5">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <div style="width: 40px; height: 3px; background: #0B4EA2;"></div>
                            <span class="text-primary fw-bold tracking-widest small uppercase">SISTEM PENGADUAN RESMI</span>
                        </div>

                        <h1 class="fw-bolder text-dark mb-4 display-4" style="letter-spacing: -2px;">
                            Wujudkan Kampus <br><span class="text-primary text-gradient">Lebih Nyaman.</span>
                        </h1>

                        <p class="text-muted mb-5 fs-5 fw-light shadow-text" style="max-width: 500px; line-height: 1.8;">
                            Platform khusus sivitas akademika <strong class="text-dark">UM Bandung</strong> untuk melaporkan kerusakan sarana dan prasarana secara <em>real-time</em>.
                        </p>

                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('fasilitas.index') }}" class="btn btn-primary px-5 py-3 rounded-pill shadow-primary fw-bold transition-up">
                                Mulai<i class="bi bi-arrow-right-circle ms-2"></i>
                            </a>
                            <div class="vr mx-2 text-muted opacity-25"></div>
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-link text-decoration-none text-dark fw-bold hover-primary px-3">
                                <i class="bi bi-search me-2"></i> Laporan
                            </a>
                        </div>

                        <div class="mt-5 pt-5 d-flex gap-4 opacity-50 border-top w-75">
                            <div class="small"><i class="bi bi-shield-check me-2 text-primary"></i> Aman & Anonim</div>
                            <div class="small"><i class="bi bi-lightning-charge me-2 text-primary"></i> Respon Cepat</div>
                            <div class="small"><i class="bi bi-graph-up me-2 text-primary"></i> Transparan</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT IMAGE (Visual Impact) --}}
            <div class="col-md-6 position-relative overflow-hidden">
                <div class="hero-image-zoom w-100 h-100" 
                     style="background: linear-gradient(135deg, rgba(11, 78, 162, 0.4), rgba(0,0,0,0.1)), url('{{ asset('images/umb.jpeg') }}') center / cover no-repeat;">
                </div>
                
                {{-- Floating Stats Card (Makin Pro) --}}
                <div class="position-absolute bottom-0 start-0 m-5 p-4 bg-white rounded-4 shadow-lg animate__animated animate__fadeInUp animate__delay-1s d-none d-lg-block">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary-subtle p-3">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark tracking-tighter">Ribuan Sivitas</h5>
                            <small class="text-muted">Telah berkontribusi</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

<style>
    /* Global Styles */
    :root {
        --umb-blue: #0B4EA2;
        --umb-light-blue: #38bdf8;
    }

    .text-primary { color: var(--umb-blue) !important; }
    .btn-primary { background-color: var(--umb-blue); border: none; }
    .btn-primary:hover { background-color: #083d7e; transform: translateY(-3px); }
    .btn-outline-umb { color: var(--umb-blue); border-color: var(--umb-blue); }
    .btn-outline-umb:hover { background-color: var(--umb-blue); color: white; }

    .text-gradient {
        background: linear-gradient(45deg, var(--umb-blue), var(--umb-light-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .shadow-primary {
        box-shadow: 0 10px 25px rgba(11, 78, 162, 0.3);
    }

    .transition-up {
        transition: all 0.3s ease;
    }

    .hero-image-zoom {
        transition: transform 10s ease-out;
    }
    .hero-image-zoom:hover {
        transform: scale(1.1);
    }

    .hover-primary:hover {
        color: var(--umb-blue) !important;
    }

    .tracking-widest { letter-spacing: 0.2rem; }
    .bg-primary-subtle { background-color: #eef4fb !important; }

    /* Mobile Responsive Optimizations */
    @media (max-width: 768px) {
        .display-5 { font-size: 2.2rem; font-weight: 800; }
        .btn { padding-top: 15px; padding-bottom: 15px; }
    }
</style>
@endsection