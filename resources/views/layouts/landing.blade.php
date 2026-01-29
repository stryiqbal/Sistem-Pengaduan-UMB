<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaduan Sarana & Prasarana UMB</title>

    {{-- ================= CSS ================= --}}
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- DataTables --}}
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
    >

    {{-- ================= CUSTOM STYLE ================= --}}
    <style>
        :root {
            --umb-blue: #0B4EA2;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* ===== UTILITIES ===== */
        .text-umb {
            color: var(--umb-blue);
        }

        .badge-umb {
            background-color: var(--umb-blue);
            color: #fff;
            font-weight: 500;
            font-size: .85rem;
        }

        .btn-umb {
            background-color: var(--umb-blue);
            border-color: var(--umb-blue);
            color: #fff;
            font-weight: 600;
            letter-spacing: .4px;
        }

        .btn-umb:hover {
            background-color: #093f85;
            border-color: #093f85;
        }

        .btn-outline-umb {
            border: 1.5px solid var(--umb-blue);
            color: var(--umb-blue);
            font-weight: 500;
            transition: .3s;
        }

        .btn-outline-umb:hover {
            background-color: var(--umb-blue);
            color: #fff;
        }

        /* ===== CATEGORY CARD ===== */
        .category-card {
            border: none;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(0,0,0,.08);
            transition: .35s ease;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 45px rgba(0,0,0,.15);
        }

        .icon-wrapper {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: linear-gradient(
                135deg,
                rgba(11,78,162,.12),
                rgba(85,60,154,.12)
            );
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .icon-wrapper i {
            font-size: 34px;
            color: var(--umb-blue);
        }

        /* ===== FORM ===== */
        .form-control-lg {
            border-radius: 14px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: var(--umb-blue);
            box-shadow: 0 0 0 .15rem rgba(11,78,162,.15);
        }

        /* ===== GLASS CARD ===== */
        .glass-card {
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 50px;
            max-width: 520px;
            box-shadow: 0 25px 60px rgba(0,0,0,.15);
        }

        /* ===== CARD & ANIMATION ===== */
        .card {
            border-radius: 18px;
            animation: fadeUp .6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== INFO BOX ===== */
        .info-box {
            background: #f8fafc;
            border-radius: 14px;
            padding: 16px 18px;
        }

        .photo-box {
            background: #f8fafc;
            padding: 16px;
            border-radius: 16px;
        }

        /* ===== ALERT ===== */
        .alert-success {
            border-left: 5px solid #198754;
            background-color: #f0fff7;
        }

        /* ===== TABLE PENGADUAN ===== */
        .table-pengaduan thead th {
            background-color: #0B4EA2;
            color: #ffffff;
            text-align: center;
            vertical-align: middle;
            border-bottom: none;
        }

        .table-pengaduan tbody tr:hover {
            background-color: rgba(11, 78, 162, 0.06);
        }

        .table-pengaduan td {
            vertical-align: middle;
        }

        .table-pengaduan thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table-pengaduan thead th:last-child {
            border-top-right-radius: 12px;
        }
    </style>
</head>

<body>

{{-- ================= CONTENT ================= --}}
@yield('content')

{{-- ================= SUCCESS TOAST ================= --}}
@if(session('success'))
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3 mt-3">
    <div
        class="toast text-bg-success border-0 shadow"
        role="alert"
        data-bs-delay="5000"
        data-bs-autohide="true"
        id="successToast"
    >
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"
            ></button>
        </div>
    </div>
</div>
@endif

{{-- ================= JS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#pengaduanTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            ordering: true,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pengaduan",
                infoEmpty: "Tidak ada data",
                paginate: {
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toastEl = document.getElementById('successToast');
        if (toastEl) {
            new bootstrap.Toast(toastEl).show();
        }
    });
</script>

@stack('scripts')
</body>
</html>