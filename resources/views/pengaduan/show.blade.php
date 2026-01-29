@extends('layouts.landing')

@section('content')
<div class="container py-4 py-md-5" style="max-width: 1000px;">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-2 rounded-pill shadow-sm d-inline-flex px-4 border">
            <li class="breadcrumb-item">
                <a href="{{ route('landing') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-house-door me-1"></i> Beranda
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}" class="text-decoration-none text-muted small">Daftar</a></li>
            <li class="breadcrumb-item active fw-bold text-umb small">Detail Laporan</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- LEFT COLUMN: DETAIL CONTENT --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                {{-- STATUS STRIP --}}
                <div class="p-1" 
                    style="background-color: {{ $pengaduan->status === 'selesai' ? '#1e40af' : ($pengaduan->status === 'diproses' ? '#38bdf8' : '#e0f2fe') }};">
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-2">
                                {{ $pengaduan->category->title }}
                            </span>
                            <h3 class="fw-800 text-dark mb-1">{{ $pengaduan->judul }}</h3>
                            <p class="text-muted small mb-0">Dilaporkan pada {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="border-start border-4 border-light ps-4 mb-5">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Deskripsi Laporan</h6>
                        <p class="text-dark leading-relaxed fs-5">
                            {{ $pengaduan->deskripsi }}
                        </p>
                    </div>

                    @if ($pengaduan->foto)
                        <div class="mt-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-3">Bukti Foto</h6>
                            <a href="{{ asset('storage/'.$pengaduan->foto) }}" target="_blank">
                                <img src="{{ asset('storage/'.$pengaduan->foto) }}" 
                                     class="img-fluid rounded-4 shadow-sm border v-zoom" 
                                     alt="Foto Pengaduan">
                            </a>
                            <p class="small text-muted mt-2 text-center"><i class="bi bi-info-circle me-1"></i> Klik gambar untuk memperbesar</p>
                        </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('pengaduan.index') }}" class="btn btn-link text-decoration-none text-muted p-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengaduan
            </a>
        </div>

        {{-- RIGHT COLUMN: STATUS & TRACKING --}}
        <div class="col-lg-4">
            {{-- STATUS CARD --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <small class="text-muted d-block mb-2">ID Tiket</small>
                    <h4 class="fw-bold text-primary-umb mb-4">#{{ $pengaduan->nomor_tiket }}</h4>
                    
                    <div class="status-steps text-start">
                        <div class="step-item mb-4 {{ in_array($pengaduan->status, ['pending', 'diproses', 'selesai']) ? 'active' : '' }}">
                            <div class="d-flex gap-3">
                                <div class="step-icon">1</div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Laporan Diterima</h6>
                                    <small class="text-muted">Menunggu validasi admin</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="step-item mb-4 {{ in_array($pengaduan->status, ['diproses', 'selesai']) ? 'active' : '' }}">
                            <div class="d-flex gap-3">
                                <div class="step-icon">2</div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Sedang Diproses</h6>
                                    <small class="text-muted">Petugas sedang menangani</small>
                                </div>
                            </div>
                        </div>

                        <div class="step-item {{ $pengaduan->status === 'selesai' ? 'active-success' : '' }}">
                            <div class="d-flex gap-3">
                                <div class="step-icon">3</div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Selesai</h6>
                                    <small class="text-muted">Fasilitas telah diperbaiki</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- HELPER CARD --}}
            <div class="card border-0 bg-primary-umb text-white rounded-4 shadow-sm shadow-primary">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                    <p class="small mb-3 opacity-75">Jika laporan Anda belum ditangani dalam 3x24 jam, silakan hubungi pusat bantuan.</p>
                    <a href="https://wa.me/6288706392829?text=Halo%20Admin%2C%20saya%20ingin%20menanyakan%20status%20pengaduan%20saya." 
                    target="_blank" 
                    class="btn btn-light btn-sm w-100 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp"></i> Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .leading-relaxed { line-height: 1.8; }
    .text-primary-umb { color: #0b4ea2; }
    .bg-primary-umb { background-color: #0b4ea2; }
    .shadow-primary { box-shadow: 0 10px 20px rgba(11, 78, 162, 0.2) !important; }

    /* Timeline Stepper CSS */
    .status-steps { position: relative; }
    .step-item { position: relative; padding-left: 10px; opacity: 0.4; }
    .step-item.active { opacity: 1; color: #0b4ea2; }
    .step-item.active-success { opacity: 1; color: #198754; }
    
    .step-icon {
        width: 28px; height: 28px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: bold;
        flex-shrink: 0;
    }
    
    .active .step-icon { background: #0b4ea2; color: white; }
    .active-success .step-icon { background: #198754; color: white; }

    .v-zoom { transition: transform .3s ease; cursor: zoom-in; }
    .v-zoom:hover { transform: scale(1.02); }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body { padding: 25px !important; }
        h3 { font-size: 1.5rem; }
        .step-item h6 { font-size: 0.9rem; }
    }
</style>
@endsection