@extends('layouts.admin')

@section('title', 'Detail Pengaduan - Admin')
@section('page-title', 'Detail Laporan')

@section('content')

<style>
:root {
    --umb-blue: #0B4EA2;
    --umb-blue-soft: #e0f2fe;
    --umb-border: #f1f5f9;
    --text-gray: #475569;
}

/* ===== CARD ===== */
.card-detail {
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-detail:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

.card-title-box {
    padding: 1.5rem 2rem;
    background: #fff;
    border-bottom: 1px solid var(--umb-border);
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-title-box i {
    color: var(--umb-blue);
    font-size: 1.5rem;
}

/* ===== INFO GRID ===== */
.info-label {
    color: #94a3b8;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}
.info-value {
    color: #1e293b;
    font-weight: 600;
    font-size: 1rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

/* ===== DESCRIPTION BOX ===== */
.desc-box {
    background-color: #f8fafc;
    border-radius: 18px;
    padding: 1.5rem;
    border: 1px solid var(--umb-border);
    line-height: 1.6;
    color: var(--text-gray);
}

/* ===== IMAGE PREVIEW ===== */
.img-preview-container {
    border-radius: 20px;
    overflow: hidden;
    border: 4px solid #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

.img-preview-container:hover {
    transform: scale(1.03);
}

/* ===== STATUS BADGE LARGE ===== */
.status-badge-large {
    padding: 14px 20px;
    border-radius: 14px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

/* ===== BUTTONS ===== */
.btn-update {
    font-weight: 700;
    transition: all 0.2s ease;
}
.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(11,78,162,0.15);
}

/* ===== ALERT ===== */
.alert-success {
    border-radius: 16px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    font-size: 0.875rem;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .card-title-box {
        padding: 1rem;
    }
    .btn-update {
        padding: 14px !important;
        width: 100%;
    }
    .status-badge-large {
        font-size: 0.9rem;
        padding: 12px;
    }
}
</style>

<div class="container-fluid py-4">
    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-lg rounded-4 p-3 mb-4 fade show" role="alert">
        <div class="d-flex align-items-center">
            <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                <i class="bi bi-check-lg text-success fs-5"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Berhasil!</h6>
                <small>{{ session('success') }}</small>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4">
        {{-- LEFT: DETAIL LAPORAN --}}
        <div class="col-lg-8">
            <div class="card card-detail mb-4">
                {{-- STATUS STRIP (Warna disamakan) --}}
                <div class="p-1" 
                    style="background-color: {{ $pengaduan->status === 'selesai' ? '#1e40af' : ($pengaduan->status === 'diproses' ? '#38bdf8' : '#e0f2fe') }};">
                </div>
                <div class="card-title-box">
                    <i class="bi bi-person-badge"></i>
                    <h6 class="fw-800 mb-0 text-dark">Profil Pelapor & Laporan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="info-grid mb-4">
                        <div>
                            <div class="info-label">Nomor Tiket</div>
                            <div class="info-value text-primary fs-5" style="color: var(--umb-blue) !important;">#{{ $pengaduan->nomor_tiket }}</div>
                        </div>
                        <div>
                            <div class="info-label">Kategori Fasilitas</div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mt-1">
                                <i class="bi bi-tag-fill me-1"></i> {{ $pengaduan->kategori }}
                            </span>
                        </div>
                        <div>
                            <div class="info-label">Nama Mahasiswa</div>
                            <div class="info-value">{{ $pengaduan->nama_mahasiswa }}</div>
                        </div>
                        <div>
                            <div class="info-label">NIM</div>
                            <div class="info-value text-muted">{{ $pengaduan->nim }}</div>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $pengaduan->email }}</div>
                        </div>
                        <div>
                            <div class="info-label">Lokasi Kejadian</div>
                            <div class="info-value"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $pengaduan->lokasi ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="info-label">Subjek Laporan</div>
                        <div class="info-value fs-5">{{ $pengaduan->judul }}</div>
                    </div>

                    <div>
                        <div class="info-label">Deskripsi Lengkap</div>
                        <div class="desc-box" style="line-height: 1.8;">{{ $pengaduan->deskripsi }}</div>
                    </div>
                </div>
            </div>

            {{-- BUKTI VISUAL --}}
            @if($pengaduan->foto)
            <div class="card card-detail">
                <div class="card-title-box">
                    <i class="bi bi-image"></i>
                    <h6 class="fw-800 mb-0 text-dark">Lampiran Bukti</h6>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="img-preview-container d-inline-block" data-bs-toggle="modal" data-bs-target="#imageModal">
                        <img src="{{ asset('storage/'.$pengaduan->foto) }}" class="img-fluid" style="max-height: 450px;">
                    </div>
                    <p class="text-muted small mt-3"><i class="bi bi-info-circle me-1"></i>Klik gambar untuk memperbesar</p>
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT: STATUS & KENDALI --}}
        <div class="col-lg-4">
            <div class="card card-detail position-sticky" style="top: 20px;">
                <div class="card-title-box">
                    <i class="bi bi-activity"></i>
                    <h6 class="fw-800 mb-0 text-dark">Status & Tindakan</h6>
                </div>
                <div class="card-body p-4">
                    @php
                        /* SINKRONISASI WARNA DENGAN LOGIKA STRIP */
                        $statusMeta = match($pengaduan->status) {
                            'selesai'  => [
                                'bg'    => '#1e40af', 
                                'text'  => '#ffffff', 
                                'icon'  => 'bi-check-circle-fill', 
                                'label' => 'Selesai'
                            ],
                            'diproses' => [
                                'bg'    => '#38bdf8', 
                                'text'  => '#000000', 
                                'icon'  => 'bi-gear-fill', 
                                'label' => 'Sedang Diproses'
                            ],
                            default    => [
                                'bg'    => '#e0f2fe', 
                                'text'  => '#0369a1', 
                                'icon'  => 'bi-clock-history', 
                                'label' => 'Laporan Diterima'
                            ]
                        };
                    @endphp

                    <div class="status-badge-large" style="background-color: {{ $statusMeta['bg'] }}; color: {{ $statusMeta['text'] }};">
                        <i class="{{ $statusMeta['icon'] }} fs-4"></i>
                        <span>{{ strtoupper($statusMeta['label']) }}</span>
                    </div>

                    <div class="alert bg-light border-0 rounded-4 small text-muted mb-4">
                        <i class="bi bi-info-square me-2"></i> Perubahan status akan memberitahu mahasiswa secara otomatis melalui email.
                    </div>

                    <form method="POST" action="{{ route('admin.pengaduan.status', $pengaduan->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="info-label">Ganti Status Pengerjaan</label>
                            <select name="status" class="form-select form-select-lg rounded-pill border-2 mt-2" 
                                    style="font-size: 14px; font-weight: 600; border-color: var(--umb-border);">
                                <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>⏳ Laporan Diterima</option>
                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>🔧 Sedang Diproses</option>
                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow btn-update" style="background: var(--umb-blue); border:none;">
                            Simpan Perubahan
                        </button>
                    </form>

                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-link w-100 text-decoration-none mt-3 text-muted fw-semibold small">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ZOOM GAMBAR --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <img src="{{ asset('storage/'.$pengaduan->foto) }}" class="img-fluid rounded-4 w-100 shadow-lg">
            </div>
        </div>
    </div>
</div>

@endsection