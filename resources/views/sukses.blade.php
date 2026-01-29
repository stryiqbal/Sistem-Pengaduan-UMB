@extends('layouts.landing')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">

    <div class="card border-0 shadow-lg text-center p-4 p-md-5 animate__animated animate__zoomIn" 
         style="max-width: 550px; border-radius: 28px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">

        {{-- SUCCESS ICON WITH ANIMATED RING --}}
        <div class="success-checkmark mb-4">
            <div class="check-icon shadow-lg mx-auto d-flex align-items-center justify-content-center">
                <i class="bi bi-check2-all text-white display-4"></i>
            </div>
        </div>

        {{-- HEADER --}}
        <div class="mb-4">
            <h2 class="fw-800 text-dark mb-2">Laporan Terkirim!</h2>
            <p class="text-muted">Aspirasi Anda sangat berarti bagi kenyamanan <br class="d-none d-md-block"> sivitas akademika UMB.</p>
        </div>

        {{-- TICKET BOX --}}
        <div class="ticket-container p-4 rounded-4 mb-4 border-2 border-dashed position-relative overflow-hidden" 
             style="background: var(--soft-blue); border-color: #cbd5e1;">
            
            <span class="badge bg-white text-umb shadow-sm px-3 py-2 rounded-pill mb-2 border small">
                ID TIKET RESMI
            </span>
            
            <div class="d-flex align-items-center justify-content-center gap-2">
                <h3 class="fw-bold text-umb mb-0 letter-spacing-2" id="ticketID">
                    {{ $pengaduan->nomor_tiket }}
                </h3>
                <button onclick="copyTicket()" class="btn btn-sm btn-white rounded-circle shadow-sm border" title="Salin Tiket">
                    <i class="bi bi-clipboard text-muted" id="copyIcon"></i>
                </button>
            </div>
            
            {{-- Toast Copy --}}
            <small id="copyToast" class="text-success fw-bold d-block mt-2 opacity-0 transition-all" style="font-size: 11px;">
                <i class="bi bi-check-circle-fill me-1"></i>Berhasil disalin!
            </small>
        </div>

        {{-- INFO --}}
        <div class="alert alert-info border-0 rounded-4 p-3 mb-4 d-flex align-items-start text-start gap-3">
            <i class="bi bi-info-circle-fill fs-4"></i>
            <small class="lh-sm text-dark-emphasis">
                Harap simpan nomor tiket ini. Anda dapat mengecek status penanganan laporan secara berkala melalui menu <strong>Lacak Laporan</strong>.
            </small>
        </div>

        {{-- FOTO PREVIEW (IF ANY) --}}
        @if ($pengaduan->foto)
            <div class="mb-4 text-start">
                <label class="small text-muted fw-bold mb-2">LAMPIRAN FOTO:</label>
                <div class="rounded-4 overflow-hidden shadow-sm border border-2 border-white">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" 
                         alt="Foto Pengaduan" 
                         class="img-fluid" 
                         style="width: 100%; max-height: 200px; object-fit: cover;">
                </div>
            </div>
        @endif

        {{-- ACTIONS --}}
        <div class="d-grid gap-3 mt-2">
            <a href="{{ route('landing') }}" class="btn btn-primary-umb btn-modern py-3 shadow">
                <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
            </a>
            <a href="{{ route('fasilitas.index') }}" class="btn btn-light btn-modern py-3 border">
                <i class="bi bi-plus-circle me-2"></i> Buat Laporan Lain
            </a>
        </div>

    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .letter-spacing-2 { letter-spacing: 2px; }
    
    .check-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10B981, #059669);
        border-radius: 50%;
        border: 8px solid #ECFDF5;
        animation: pulse-green 2s infinite;
    }

    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .btn-white { background: #fff; border: 1px solid #dee2e6; }
    .btn-white:hover { background: #f8f9fa; }
    
    /* Mobile adjustments */
    @media (max-width: 576px) {
        .card { border-radius: 0; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; }
        .display-4 { font-size: 2.5rem; }
    }
</style>

<script>
    function copyTicket() {
        const ticketText = document.getElementById('ticketID').innerText;
        navigator.clipboard.writeText(ticketText);
        
        const toast = document.getElementById('copyToast');
        const icon = document.getElementById('copyIcon');
        
        toast.style.opacity = "1";
        icon.classList.replace('bi-clipboard', 'bi-check-all');
        icon.classList.add('text-success');

        setTimeout(() => {
            toast.style.opacity = "0";
            icon.classList.replace('bi-check-all', 'bi-clipboard');
            icon.classList.remove('text-success');
        }, 2000);
    }
</script>
@endsection