
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Safae')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* ==================================================
           SAFae - PASTEL MESH GRADIENT LIGHT MODE
        ================================================== */

        :root {
            --bg: #f5f8ff;
            --white: #ffffff;

            --primary: #7189cf;
            --primary-dark: #5875b8;
            --blue: #78bde8;

            --text: #30364b;
            --text-secondary: #66728a;
            --muted: #929db2;

            --border: #e8edf8;

            --baby-blue: #a5d8f3;
            --lavender: #e8c9f0;
            --baby-pink: #f5cde5;
            --mint: #b8e5d8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Space Grotesk', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background:
                radial-gradient(
                    ellipse at 10% 10%,
                    rgba(157, 211, 245, 0.65),
                    transparent 45%
                ),
                radial-gradient(
                    ellipse at 90% 15%,
                    rgba(245, 190, 224, 0.55),
                    transparent 45%
                ),
                radial-gradient(
                    ellipse at 55% 50%,
                    rgba(207, 197, 245, 0.35),
                    transparent 50%
                ),
                radial-gradient(
                    ellipse at 5% 95%,
                    rgba(174, 224, 211, 0.45),
                    transparent 40%
                ),
                linear-gradient(
                    135deg,
                    #eaf6ff 0%,
                    #f5edff 50%,
                    #fff0f7 100%
                );

            background-attachment: fixed;
            color: var(--text);
            overflow-x: hidden;
            min-height: 100vh;
        }

        a {
            transition: all .25s ease;
        }

        /* ==================================================
           NAVBAR
        ================================================== */

        .navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 75px;

            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            border-bottom: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 25px rgba(140, 160, 200, 0.08);

            z-index: 1000;
            padding: 0 28px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;

            background: linear-gradient(
                135deg,
                #7189cf,
                #65b8e8,
                #c69bdc
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            text-decoration: none;
            letter-spacing: -1px;
            flex-shrink: 0;
        }

        .navbar-brand:hover {
            opacity: .8;
        }

        /* ==================================================
           SEARCH
        ================================================== */

        .navbar-search {
            flex: 1;
            display: flex;
            justify-content: center;
            margin: 0 30px;
        }

        .search-wrapper {
            width: 420px;
            max-width: 100%;
            position: relative;
        }

        .search-input {
            width: 100%;

            border: 1px solid rgba(255, 255, 255, .9);

            background: linear-gradient(
                135deg,
                rgba(255,255,255,.85),
                rgba(235,245,255,.85)
            );

            color: var(--text);

            padding: 14px 50px 14px 18px;
            border-radius: 16px;

            outline: none;
            transition: .25s;
        }

        .search-input::placeholder {
            color: #a0aabd;
        }

        .search-input:focus {
            background: #ffffff;
            border-color: #a5d8f3;

            box-shadow: 0 0 0 4px rgba(114, 183, 245, .15);
        }

        .search-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #8da8d5;
        }

        /* ==================================================
           RIGHT NAVIGATION
        ================================================== */

        .nav-right {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .nav-icon {
            width: 45px;
            height: 45px;
            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #eaf4ff,
                #f2eaff,
                #fff0f7
            );

            color: #7189cf;

            display: flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;
            transition: .25s;
        }

        .nav-icon:hover {
            background: linear-gradient(
                135deg,
                #dceeff,
                #e9e1ff
            );

            color: #5875b8;
            transform: translateY(-2px);
        }

        /* ==================================================
           PROFILE
        ================================================== */

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;

            text-decoration: none;
            color: var(--text);
            font-weight: 700;
        }

        .profile-btn img {
            width: 45px;
            height: 45px;

            border-radius: 50%;
            border: 2px solid #ffffff;

            object-fit: cover;

            box-shadow: 0 2px 10px rgba(120, 150, 200, .15);
        }

        .profile-name {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: linear-gradient(
                120deg,
                #e5f2ff,
                #eee8ff,
                #fceafa
            );

            color: #7189cf;

            padding: 10px 18px;
            border-radius: 50px;

            border: 1px solid rgba(255,255,255,.9);

            font-size: 16px;
            font-weight: 700;
        }

        /* ==================================================
           SIDEBAR
        ================================================== */

        .sidebar {
            position: fixed;
            top: 75px;
            left: 0;

            width: 270px;
            height: calc(100vh - 75px);

            background: linear-gradient(
                180deg,
                rgba(255,255,255,.94),
                rgba(241,247,255,.91),
                rgba(250,240,255,.90)
            );

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            border-right: 1px solid rgba(255,255,255,.8);

            padding: 25px 16px;
            overflow-y: auto;
            z-index: 900;
        }

        .sidebar-title {
            font-size: .75rem;
            text-transform: uppercase;

            color: #a0aabd;
            font-weight: 800;

            margin: 22px 14px 12px;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 14px;

            padding: 14px 16px;
            margin-bottom: 8px;

            border-radius: 14px;
            text-decoration: none;

            color: #66728a;
            font-weight: 700;

            transition: all .25s ease;
        }

        .sidebar a i {
            width: 18px;
            font-size: 1rem;
        }

        .sidebar a:hover {
            background: linear-gradient(
                135deg,
                #e4f2ff,
                #eee8ff,
                #fceafa
            );

            color: #7189cf;
            transform: translateX(3px);
        }

        .sidebar a.active {
            background: linear-gradient(
                120deg,
                #e2f1ff,
                #eee8ff,
                #fceafa
            );

            color: #7189cf;

            border: 1px solid rgba(255,255,255,.9);

            box-shadow: 0 4px 15px rgba(140, 160, 210, .10);
        }

        /* ==================================================
           PREMIUM MENU
        ================================================== */

        .sidebar-premium {
            display: flex;
            align-items: center;
            gap: 12px;

            color: #d99a16 !important;
            font-weight: 700;

            transition: all .3s ease;
        }

        .sidebar-premium i {
            color: #e5a817 !important;
            font-size: 17px;
        }

        .sidebar-premium .premium-vip-badge {
            margin-left: auto;
            padding: 3px 9px;

            background: linear-gradient(
                135deg,
                #fcd34d,
                #f59e0b
            );

            color: #78350f;
            border-radius: 7px;

            font-size: 10px;
            font-weight: 800;

            box-shadow: 0 2px 8px rgba(251, 191, 36, .15);
        }

        .sidebar-premium:hover {
            color: #b77908 !important;
            background: #fff9e8;
        }

        .sidebar-premium:hover i {
            color: #d99a16 !important;
        }

        .sidebar-premium.active {
            color: #c58a0c !important;

            background: linear-gradient(
                135deg,
                #fff8e6,
                #fffdf5
            );

            border: 1px solid #f8e6b5;
            border-radius: 14px;
        }

        .sidebar-premium.active i {
            color: #d99a16 !important;
        }

        /* ==================================================
           MAIN CONTENT
        ================================================== */

        main {
            margin-left: 270px;
            margin-top: 75px;

            padding: 35px;
            min-height: 100vh;

            background: transparent;
        }

        /* ==================================================
           CARD GLOBAL
        ================================================== */

        .card {
            background: rgba(255,255,255,.84);

            border: 1px solid rgba(255,255,255,.95);
            border-radius: 20px;

            box-shadow: 0 8px 25px rgba(130, 155, 200, .08);

            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            transition: all .3s ease;
        }

        .card:hover {
            box-shadow: 0 12px 30px rgba(130, 155, 200, .15);
        }

        /* ==================================================
           BUTTON GLOBAL
        ================================================== */

        .btn-primary {
            background: linear-gradient(
                135deg,
                #8296ed,
                #63b9e9,
                #b69cdd
            );

            border: none;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(
                135deg,
                #7187e0,
                #50a8dc,
                #a78bd1
            );

            color: #ffffff;
            transform: translateY(-1px);
        }

        /* ==================================================
           DROPDOWN
        ================================================== */

        .dropdown-menu {
            background: rgba(255,255,255,.96);

            border: 1px solid rgba(255,255,255,.95) !important;
            border-radius: 16px;

            padding: 10px;
            min-width: 220px;

            box-shadow: 0 12px 30px rgba(88,125,190,.12);

            backdrop-filter: blur(15px);
        }

        .dropdown-item {
            color: #626b80;

            border-radius: 12px;
            font-weight: 600;

            padding: 12px 14px;
            transition: .2s;
        }

        .dropdown-item:hover {
            background: linear-gradient(
                135deg,
                #edf2ff,
                #e5f5ff,
                #fceafa
            );

            color: #6388d8;
        }

        .dropdown-divider {
            border-color: #e8edf8;
        }

        /* ==================================================
           FOOTER
        ================================================== */

        .footer {
            margin-left: 270px;
            padding: 25px;

            border-top: 1px solid rgba(255,255,255,.8);

            background: rgba(255,255,255,.72);

            text-align: center;
            color: #929db2;
            font-size: 13px;
        }

        /* ==================================================
           SCROLLBAR
        ================================================== */

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(
                #a9c9f7,
                #c7b5ed,
                #f0c6df
            );

            border-radius: 10px;
        }

        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media(max-width: 992px) {

            .sidebar {
                display: none;
            }

            main,
            .footer {
                margin-left: 0;
            }

            .navbar-search {
                display: none;
            }

            .navbar-custom {
                padding: 0 18px;
            }
        }

        @media(max-width: 576px) {

            .navbar-brand {
                font-size: 1.5rem;
            }

            .profile-name {
                display: none;
            }

            main {
                padding: 20px 15px;
            }

            .footer {
                padding: 20px 15px;
            }
        }

    </style>

    @guest
        <style>
            main,
            .footer {
                margin-left: 0 !important;
            }
        </style>
    @endguest

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar-custom">

    <a href="{{ url('/') }}" class="navbar-brand">
        Safae
    </a>

    <div class="nav-right">

        <a href="#" class="nav-icon">
            <i class="fa-regular fa-bell"></i>
        </a>

        @auth

            <div class="dropdown">

                <a href="#"
                   class="profile-btn"
                   data-bs-toggle="dropdown">

                    @if(Auth::user()->foto_profil)

                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                             alt="Profile">

                    @elseif(Auth::user()->profile_image)

                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                             alt="Profile">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}&background=38bdf8&color=ffffff"
                             alt="Profile">

                    @endif

                    <span class="profile-name">
                        {{ Auth::user()->username }}
                    </span>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="{{ url('/profile') }}">
                            <i class="fa fa-user me-2"></i>
                            Profile
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item text-danger"
                           href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                            <i class="fa fa-right-from-bracket me-2"></i>
                            Logout

                        </a>
                    </li>

                </ul>

            </div>

        @else

            <a href="{{ route('login') }}"
               class="btn btn-sm text-white fw-bold px-3 py-2 rounded-3"
               style="background: linear-gradient(135deg, #8296ed, #63b9e9, #b69cdd); border: none;">

                <i class="fa-solid fa-right-to-bracket me-2"></i>
                Masuk

            </a>

        @endauth

    </div>

</nav>

<!-- ================= SIDEBAR ================= -->

@auth

<aside class="sidebar">

    <div class="sidebar-title">
        Menu Utama
    </div>

    <a href="{{ route('user.dashboard') }}"
       class="{{ request()->is('user/dashboard') ? 'active' : '' }}">

        <i class="fa-solid fa-chart-line"></i>
        Dashboard

    </a>

    <a href="{{ route('writer.books.index') }}"
       class="{{ request()->is('penulis*') ? 'active' : '' }}">

        <i class="fa-solid fa-feather-pointed"></i>
        Studio Penulis

    </a>

    <div class="sidebar-title">
        Koleksi
    </div>

    <a href="{{ route('genre.index') }}"
       class="{{ request()->routeIs('genre.index') ? 'active' : '' }}">

        <i class="fa-solid fa-book-bookmark"></i>
        Genre Buku

    </a>

    <a href="{{ route('premium.books') }}"
       class="sidebar-premium {{ request()->routeIs('premium.books') ? 'active' : '' }}">

        <i class="fa-solid fa-crown"></i>

        <span>Buku Premium</span>

        <span class="premium-vip-badge">
            VIP
        </span>

    </a>

    <a href="{{ route('favorite.index') }}"
       class="{{ request()->routeIs('favorite.index') ? 'active' : '' }}">

        <i class="fa-regular fa-heart"></i>
        Buku Favorit

    </a>

    <a href="{{ route('bookmark.index') }}"
       class="{{ request()->is('bookmarks*') ? 'active' : '' }}">

        <i class="fa-solid fa-bookmark"></i>
        Bookmark Saya

    </a>

    <a href="{{ route('reading.history') }}"
       class="{{ request()->routeIs('reading.history') ? 'active' : '' }}">

        <i class="fa-solid fa-clock-rotate-left"></i>
        Riwayat Baca

    </a>

    <a href="{{ route('resume.my') }}"
       class="{{ request()->is('my-resumes') ? 'active' : '' }}">

        <i class="fa-solid fa-book-open-reader"></i>
        Resume Saya

    </a>

    <div class="sidebar-title">
        Lainnya
    </div>

    <a href="{{ route('forum.index') }}"
       class="{{ request()->routeIs('forum.index') ? 'active' : '' }}">

        <i class="fa-solid fa-comments"></i>
        Forum

    </a>

    <a href="{{ route('reward.index') }}"
       class="{{ request()->routeIs('reward.index') ? 'active' : '' }}">

        <i class="fa-solid fa-gift"></i>
        Reward

    </a>

    <a href="{{ route('reading.statistics') }}"
       class="{{ request()->routeIs('reading.statistics') ? 'active' : '' }}">

        <i class="fa-solid fa-chart-line"></i>
        Statistik Membaca

    </a>

</aside>

@endauth

<!-- ================= MAIN CONTENT ================= -->

<main>
    @yield('content')
</main>

<!-- ================= FOOTER ================= -->

<footer class="footer">
    © {{ date('Y') }} Safae. All rights reserved.
</footer>

<!-- ================= LOGOUT FORM ================= -->

<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST"
      class="d-none">

    @csrf

</form>

</body>
</html>
