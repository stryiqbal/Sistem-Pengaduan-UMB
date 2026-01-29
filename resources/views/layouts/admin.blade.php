<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Panel') - UMB</title>

{{-- Bootstrap & Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
:root {
    --umb-blue: #0B4EA2;
    --umb-blue-dark: #083b7d;
    --umb-blue-soft: #e6f0ff;
    --umb-bg: #f8f9fa;
    --sidebar-width: 260px;
    --sidebar-collapsed: 78px;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--umb-bg);
    overflow-x: hidden;
}

/* Sidebar */
.sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(180deg, var(--umb-blue), var(--umb-blue-dark));
    display: flex;
    flex-direction: column;
    transition: all .3s ease;
    z-index: 1050;
    overflow-x: hidden;
}

.sidebar.collapsed { width: var(--sidebar-collapsed); }

.brand {
    padding: 1.8rem 1rem;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,.12);
}

.brand img { width: 48px; transition: transform .3s; }
.sidebar.collapsed .brand img { transform: scale(0.8); }

.brand h6, .brand small, .nav-link span { transition: opacity .3s; }
.sidebar.collapsed h6, .sidebar.collapsed small, .sidebar.collapsed .nav-link span {
    opacity: 0;
    pointer-events: none;
}

.nav-link {
    color: rgba(255,255,255,.85);
    padding: .85rem 1.3rem;
    margin: 4px 10px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    transition: .2s;
}

.nav-link i { font-size: 1.3rem; min-width: 28px; }
.nav-link:hover { background: rgba(255,255,255,.12); color: #fff; }
.nav-link.active {
    background: rgba(255,255,255,.2);
    font-weight: 600;
}
.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px; height: 60%;
    background: #fff;
    border-radius: 0 4px 4px 0;
}

/* Main Content */
.main-content {
    margin-left: var(--sidebar-width);
    padding: 2rem;
    transition: margin-left .3s ease;
}
.main-content.expanded { margin-left: var(--sidebar-collapsed); }

/* Topbar */
.topbar {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    padding: .8rem 1.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

#sidebarToggle {
    font-size: 1.6rem;
    cursor: pointer;
    color: var(--umb-blue);
    transition: .2s;
}
#sidebarToggle:hover { color: var(--umb-blue-dark); transform: scale(1.1); }

/* Cards */
.card {
    border-radius: 18px;
    transition: .3s;
}
.card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,.08); }

/* Tables */
.table-pengaduan thead th {
    background-color: var(--umb-blue);
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    font-size: 12px;
}
.table-pengaduan tbody tr:hover { background-color: rgba(11,78,162,.06); }

/* Buttons */
.btn-umb {
    background-color: var(--umb-blue);
    color: #fff;
    border-radius: 50px;
    font-weight: 600;
    transition: .3s;
}
.btn-umb:hover { background-color: var(--umb-blue-dark); transform: translateY(-2px); box-shadow: 0 6px 15px rgba(11,78,162,.2); }
.btn-outline-umb {
    border: 1.5px solid var(--umb-blue);
    color: var(--umb-blue);
    font-weight: 500;
}
.btn-outline-umb:hover { background-color: var(--umb-blue); color: #fff; }

/* Badges */
.badge-umb { background-color: var(--umb-blue); color: #fff; font-size: .85rem; }

/* Mobile */
@media (max-width: 992px) {
    .sidebar { left: -100%; }
    .sidebar.active { left: 0; box-shadow: 0 0 40px rgba(0,0,0,.35); }
    .main-content { margin-left: 0 !important; padding: 1.2rem; }
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 1040;
        opacity: 0;
        transition: opacity .3s ease;
    }
    .sidebar-overlay.show { display: block; opacity: 1; }
}
</style>
</head>
<body>

<div class="sidebar-overlay"></div>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('images/logoumb.jpg') }}" class="rounded-circle mb-2">
        <h6 class="fw-bold text-white mb-0">Admin UMB</h6>
        <small class="text-white-50">Sistem Pengaduan</small>
    </div>

    <div class="nav flex-column mt-3 flex-grow-1">
        <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        <a href="/admin/pengaduan" class="nav-link {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> <span>Pengaduan</span>
        </a>
    </div>

    <div class="p-3 border-top border-light border-opacity-10">
        <form method="POST" action="/admin/logout">
            @csrf
            <button class="nav-link bg-transparent border-0 text-white w-100 text-start">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </button>
        </form>
    </div>
</div>

{{-- Main Content --}}
<div class="main-content" id="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <div id="sidebarToggle"><i class="bi bi-list"></i></div>
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
        </div>
        <div class="fw-semibold d-none d-sm-block">{{ session('admin_name', 'Admin UMB') }}</div>
    </div>

    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main-content');
const toggle = document.getElementById('sidebarToggle');
const overlay = document.querySelector('.sidebar-overlay');

const isDesktop = () => window.innerWidth > 992;

function initSidebar() {
    if (isDesktop()) {
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
            main.classList.add('expanded');
        }
    } else {
        sidebar.classList.remove('collapsed', 'active');
        main.classList.remove('expanded');
        overlay.classList.remove('show');
    }
}
initSidebar();

toggle.addEventListener('click', () => {
    if (isDesktop()) {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
    } else {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('show');
    }
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('show');
});

window.addEventListener('resize', initSidebar);
</script>

@stack('scripts')
</body>
</html>
