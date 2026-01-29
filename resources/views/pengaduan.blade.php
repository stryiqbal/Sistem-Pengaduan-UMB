@extends('layouts.landing')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            {{-- ================= BREADCRUMB ================= --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-white p-2 rounded-pill shadow-sm d-inline-flex px-4 border">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none text-muted small"> <i class="bi bi-house-door me-1"></i>Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('fasilitas.index') }}" class="text-decoration-none text-muted small">Kategori</a></li>
                    <li class="breadcrumb-item active fw-bold text-umb small" aria-current="page">
                        <i class="bi bi-{{ $category->icon ?? 'tag' }} me-1"></i> {{ $category->title }}
                    </li>
                </ol>
            </nav>

            {{-- ================= FORM CARD ================= --}}
            <div class="card border-0 rounded-4 shadow-lg overflow-hidden animate__animated animate__fadeInUp">
                
                {{-- ACCENT BAR --}}
                <div style="height: 6px; background: linear-gradient(90deg, #0B4EA2, #38bdf8);"></div>

                {{-- HEADER --}}
                <div class="card-header bg-white border-0 text-center px-4 pt-5 pb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle rounded-circle mb-3 shadow-sm animate__animated animate__bounceIn"
                    style="width: 80px; height: 80px; border: 4px solid #fff;">
                        <i class="bi bi-{{ $category->icon ?? 'pencil-square' }} fs-1 text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Form Pengaduan</h3>
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                        <span class="badge rounded-pill bg-primary px-3 py-2 shadow-sm">{{ $category->title }}</span>
                    </div>
                    <p class="text-muted mx-auto mb-0" style="max-width: 500px;">
                        Sampaikan keluhan terkait <strong class="text-dark">{{ $category->title }}</strong> dengan detail. Identitas Anda akan kami jaga kerahasiaannya sesuai prosedur yang berlaku.
                    </p>
                </div>

                {{-- BODY --}}
                <div class="card-body px-4 px-md-5 py-4">
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="formPengaduan">
                        @csrf
                        <input type="hidden" name="fasilitas_category_id" value="{{ $category->id }}">

                        <div class="row g-4">
                            {{-- Section 1: Identitas --}}
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-person-badge text-primary"></i>
                                    <span class="fw-bold text-uppercase small tracking-wider text-muted">Identitas Mahasiswa</span>
                                </div>
                                <hr class="mt-0 mb-3 opacity-10">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama_mahasiswa" class="form-control border-start-0 ps-0 custom-input" placeholder="Contoh: Budi Santoso" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="nim" class="form-control border-start-0 ps-0 custom-input" placeholder="Masukkan 10 digit NIM" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Email Institusi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 custom-input" placeholder="nama@student.umb.ac.id" required>
                                </div>
                            </div>

                            {{-- Section 2: Detail Laporan --}}
                            <div class="col-12 mt-5">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-exclamation-triangle text-primary"></i>
                                    <span class="fw-bold text-uppercase small tracking-wider text-muted">Detail Laporan</span>
                                </div>
                                <hr class="mt-0 mb-3 opacity-10">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Subjek/Judul Pengaduan</label>
                                <input type="text" name="judul" class="form-control custom-input" placeholder="Tuliskan inti masalah secara singkat" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Lokasi Kejadian <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="lokasi" class="form-control border-start-0 ps-0 custom-input" placeholder="Gedung, Lantai, atau Nama Ruangan">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Deskripsi Kronologi</label>
                                <textarea name="deskripsi" rows="5" class="form-control custom-input" placeholder="Ceritakan secara detail apa yang terjadi..." required></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Lampiran Foto <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="upload-container rounded-3 p-4 text-center border-dashed position-relative bg-light transition-all">
                                    
                                    <div id="upload-placeholder">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-primary mb-2 d-block"></i>
                                        <span class="d-block small text-muted mb-2">Klik untuk upload foto bukti (PNG, JPG maks 2MB)</span>
                                    </div>

                                    <div id="preview-area" class="d-none">
                                        <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded-3 mb-2 shadow-sm" style="max-height: 180px;">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <span id="file-name-display" class="small fw-bold"></span>
                                        </div>
                                    </div>

                                    <input type="file" name="foto" id="foto-input" class="form-control position-absolute top-0 start-0 opacity-0 h-100 w-100 cursor-pointer" accept="image/*">
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-5">
                            {{-- Tombol Batal/Kembali --}}
                            <div class="order-2 order-md-1">
                                <a href="{{ route('fasilitas.index') }}" 
                                class="btn btn-light rounded-pill px-4 py-2 fw-bold text-muted border shadow-sm small">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>

                            {{-- Tombol Kirim --}}
                            <div class="order-1 order-md-2">
                                <button type="submit" 
                                        class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-primary btn-submit text-white">
                                    Kirim Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FOOTER INFO --}}
            <div class="text-center mt-4">
                <p class="small text-muted">
                    <i class="bi bi-shield-lock-fill me-1"></i> Data Anda dienkripsi dan hanya dapat diakses oleh pihak berwenang.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom Styling */
    .bg-primary { background-color: #0B4EA2 !important; }
    .text-primary { color: #0B4EA2 !important; }
    .bg-primary-subtle { background-color: #eef4fb !important; }
    .shadow-primary { box-shadow: 0 4px 14px 0 rgba(11, 78, 162, 0.39); }
    
    .custom-input {
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .custom-input:focus {
        border-color: #0B4EA2;
        box-shadow: 0 0 0 4px rgba(11, 78, 162, 0.1);
        background-color: #fff;
    }

    .border-dashed {
        border: 2px dashed #cbd5e1;
        transition: all 0.3s ease;
    }

    .upload-container:hover {
        border-color: #0B4EA2;
        background-color: #f8fafc !important;
    }

    .cursor-pointer { cursor: pointer; }

    .btn-submit {
        transition: all 0.3s ease;
        background: #0B4EA2;
        border: none;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(11, 78, 162, 0.4);
        background: #083d7e;
    }

    .hover-primary:hover { color: #0B4EA2 !important; }

    /* Mobile Responsive Optimizations */
    @media (max-width: 768px) {
        .card-body { padding: 1.5rem !important; }
        .card-header { padding-top: 2rem !important; }
        .input-group-text { display: none; } /* Simpler look on mobile */
        .border-start-0 { border-left: 1px solid #e2e8f0 !important; border-radius: 0.375rem !important; padding-left: 1rem !important; }
    }
</style>

@push('scripts')
<script>
    const fotoInput = document.getElementById('foto-input');
    const previewArea = document.getElementById('preview-area');
    const imagePreview = document.getElementById('image-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const fileNameDisplay = document.getElementById('file-name-display');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validasi ukuran 2MB
            if (file.size > 2 * 1024 * 1024) {
                alert("File terlalu besar! Maksimal 2MB.");
                this.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                fileNameDisplay.innerHTML = `<i class="bi bi-image me-1"></i> ${file.name}`;
                uploadPlaceholder.classList.add('d-none');
                previewArea.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    function resetUpload() {
        fotoInput.value = "";
        uploadPlaceholder.classList.remove('d-none');
        previewArea.classList.add('d-none');
        imagePreview.src = "#";
    }
</script>
@endpush
@endsection