<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg: #0b0f19; /* Hitam pekat obsidian */
            --sidebar-bg: #111827; /* Abu-abu baja solid */
            --header-bg: rgba(17, 24, 39, 0.8);
            --primary: #06b6d4; /* Electric Cyan */
            --accent: #3b82f6; 
            --text: #f8fafc;
            --muted: #64748b;
            --border: rgba(255, 255, 255, 0.05);
            --sidebar-width: 290px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Space Grotesk', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ================= SIDEBAR DESIGN ================= */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            padding: 24px 14px;
            overflow-y: auto;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 999px;
        }

        .sidebar-header {
            padding: 10px 16px 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header h3 span {
            color: var(--primary);
            font-size: 0.7rem;
            background: rgba(6, 182, 212, 0.08);
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid rgba(6, 182, 212, 0.15);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .sidebar-menu li a i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            color: #475569;
            transition: color 0.2s ease-in-out;
        }

        .sidebar-menu li a:hover {
            background: rgba(255, 255, 255, 0.02);
            color: #fff;
        }

        .sidebar-menu li a:hover i {
            color: #94a3b8;
        }

        /* Indikator Menu Aktif Modern */
        .sidebar-menu li.active a,
        .sidebar-menu li a.active {
            background: rgba(6, 182, 212, 0.05);
            color: var(--primary);
            font-weight: 700;
        }

        .sidebar-menu li.active a::before,
        .sidebar-menu li a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 3px;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-menu li.active a i,
        .sidebar-menu li a.active i {
            color: var(--primary);
        }

        /* ================= HEADER PANEL ================= */
        .admin-header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: 75px;
            background: var(--header-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 40px;
            display: flex;
            align-items: center;
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-toggle {
            background: #1e293b;
            border: 1px solid var(--border);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }
        .sidebar-toggle:hover {
            background: #334155;
        }

        .user-info p {
            color: #fff;
            font-size: 0.95rem;
        }

        .user-info small {
            color: var(--muted);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-logout-admin {
            background: transparent;
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-logout-admin:hover {
            background: rgba(239, 68, 68, 0.08);
            border-color: #ef4444;
            color: #ef4444;
        }

        /* ================= MAIN INTERFACE WRAPPER ================= */
        .admin-main-content {
            margin-left: var(--sidebar-width);
            padding: 110px 40px 40px;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Overlay Background saat Sidebar Mobile Terbuka */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
            display: none;
        }
        .sidebar-overlay.show {
            display: block;
        }

        /* ================= RESPONSIVE VIEW ================= */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .admin-header {
                left: 0 !important;
                padding: 0 24px;
            }
            .admin-main-content {
                margin-left: 0 !important;
                padding: 105px 24px 24px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<nav class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <h3><i class="fa-solid fa-screwdriver-wrench text-primary"></i>Panel Admin <span>Menu</span></h3>
    </div>

    <ul class="sidebar-menu">
        {{-- DASHBOARD --}}
        <li class="{{ request()->is('admin') ? 'active' : '' }}">
            <a href="{{ url('/admin') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard Sistem
            </a>
        </li>

        {{-- GENRE & BUKU --}}
        <li class="{{ request()->is('admin/genre') || request()->is('admin/books*') ? 'active' : '' }}">
            <a href="{{ url('/admin/genre') }}">
                <i class="fa-solid fa-book"></i> Kelola Genre & Buku
            </a>
        </li>

        {{-- PREMIUM --}}
                <li>
            <a href="{{ route('admin.premium.index') }}">
                <i class="fas fa-crown"></i>
                verifikasi Pengajuan Premium
            </a>
        </li>

        <li>
    <a href="{{ route('admin.premium.books') }}">
        <i class="fas fa-book"></i>
        Kelola Buku Premium
    </a>
</li>

        {{-- USER --}}
        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <a href="{{ url('/admin/users') }}">
                <i class="fa-solid fa-circle-user"></i> Kelola User
            </a>
        </li>

        {{-- FORUM --}}
        <li class="{{ request()->is('admin/forum*') ? 'active' : '' }}">
            <a href="{{ url('/admin/forum') }}">
                <i class="fa-solid fa-comment"></i> Kelola Forum
            </a>
        </li>

        {{-- KELOLA KOMENTAR --}}
        <li class="{{ request()->is('admin/komentar*') ? 'active' : '' }}">
            <a href="{{ route('admin.komentar.index') }}">
                <i class="fa-solid fa-comments"></i> Kelola Komentar
            </a>
        </li>

        {{-- KELOLA REWARD --}}
        <li class="{{ request()->is('admin/reward*') ? 'active' : '' }}">
            <a href="{{ route('admin.rewards.index') }}">
                <i class="fa-solid fa-gift"></i> Kelola Reward
            </a>
        </li>

        {{-- KELOLA BUKU FAV --}}
        <li class="{{ request()->routeIs('admin.favorit.*') || request()->is('admin/favorit*') ? 'active' : '' }}">
            <a href="{{ route('admin.favorit.index') }}">
                <i class="fas fa-heart"></i> Kelola Buku Favorit
            </a>
        </li>

        {{-- RIWAYAT BACA --}}
        <li class="{{ request()->is('admin/riwayat-baca*') ? 'active' : '' }}">
             <a href="{{ route('admin.kelolariwayat.index') }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Kelola Riwayat Baca
             </a>
        </li>

        {{-- ULASAN --}}
        <li class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fa-solid fa-star"></i> Kelola Ulasan
            </a>
        </li>


        {{-- kelola notifikasi --}}
        <li class="{{ request()->is('admin/notifications*') ? 'active' : '' }}">
            <a href="{{ route('admin.notifications.index') }}">
                <i class="fa-solid fa-bell"></i> Kelola Notifikasi
            </a>
        </li>

        {{-- KELOLA PROMOSI --}}
        <li class="{{ request()->is('admin/promotions*') ? 'active' : '' }}">
            <a href="{{ route('admin.promotions.index') }}">
                <i class="fa-solid fa-bullhorn"></i> Kelola Promosi
            </a>
        </li>
    </ul>
</nav>

<header class="admin-header">
    <button class="sidebar-toggle d-lg-none me-3" id="toggleBtn">
        <i class="fas fa-bars"></i>
    </button>

    <div class="user-menu ms-auto d-flex align-items-center">
        @auth
            <div class="user-info text-end me-3">
                <p class="mb-0 fw-bold">{{ Auth::user()->username }}</p>
                <small>Administrator</small>
            </div>
        @endauth
        
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-logout-admin">
                <i class="fa-solid fa-power-off me-1"></i> Keluar Aplikasi
            </button>
        </form>
    </div>
</header>

<div class="admin-main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const toggleBtn = document.getElementById('toggleBtn');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
        adminSidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', toggleSidebar);
</script>

@stack('scripts')

</body>
</html>