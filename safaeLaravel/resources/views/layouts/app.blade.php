<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Safae')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --bg: #0f172a;
            --sidebar: #1e293b;
            --primary: #38bdf8;
            --text: #f1f5f9;
            --muted: #64748b;
            --border: #334155;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Space Grotesk', sans-serif;
        }

        body{
            background:var(--bg);
            color:var(--text);
            overflow-x:hidden;
        }

        /* ================= NAVBAR ================= */

        .navbar-custom{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:75px;
            background:rgba(15, 23, 42, 0.88);
            backdrop-filter:blur(14px);
            border-bottom:1px solid var(--border);
            z-index:1000;
            padding:0 28px;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .navbar-brand{
            font-size:1.8rem;
            font-weight:800;
            color:var(--primary);
            text-decoration:none;
            letter-spacing:-1px;
            flex-shrink:0;
        }

        /* SEARCH */

        .navbar-search{
            flex:1;
            display:flex;
            justify-content:center;
            margin:0 30px;
        }

        .search-wrapper{
            width:420px;
            max-width:100%;
            position:relative;
        }

        .search-input{
            width:100%;
            border:none;
            background:#1e293b;
            color:#fff;
            padding:14px 50px 14px 18px;
            border-radius:16px;
            outline:none;
            transition:.2s;
        }

        .search-input::placeholder{
            color:#94a3b8;
        }

        .search-input:focus{
            background:#334155;
            box-shadow:0 0 0 3px rgba(56,189,248,.15);
        }

        .search-icon{
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
        }

        /* RIGHT NAV */

        .nav-right{
            display:flex;
            align-items:center;
            gap:14px;
            flex-shrink:0;
        }

        .nav-icon{
            width:45px;
            height:45px;
            border-radius:14px;
            background:#1e293b;
            color:var(--text);
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
            transition:.2s;
        }

        .nav-icon:hover{
            background:#334155;
            color:var(--primary);
        }

        /* PROFILE */

        .profile-btn{
            display:flex;
            align-items:center;
            gap:10px;
            text-decoration:none;
            color:#fff;
            font-weight:700;
        }

        .profile-btn img{
            width:45px;
            height:45px;
            border-radius:50%;
            border:2px solid #334155;
            object-fit:cover;
        }

        .profile-name {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        padding: 10px 18px;
        border-radius: 50px;
        border: 1px solid rgba(56,189,248,.3);
        font-size: 16px;
        font-weight: 700;
    }

        /* ================= SIDEBAR ================= */

        .sidebar{
            position:fixed;
            top:75px;
            left:0;
            width:270px;
            height:calc(100vh - 75px);
            background:var(--sidebar);
            border-right:1px solid var(--border);
            padding:25px 16px;
            overflow-y:auto;
        }

        .sidebar-title{
            font-size:.75rem;
            text-transform:uppercase;
            color:var(--muted);
            font-weight:800;
            margin:22px 14px 12px;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:14px;
            padding:14px 16px;
            margin-bottom:8px;
            border-radius:16px;
            text-decoration:none;
            color:var(--text);
            font-weight:700;
            transition:.2s;
        }

        .sidebar a i{
            width:18px;
            font-size:1rem;
        }

        .sidebar a:hover{
            background:#334155;
            color:var(--primary);
        }

        .sidebar a.active{
            background:rgba(56,189,248,.12);
            color:var(--primary);
            border:1px solid rgba(56,189,248,.2);
        }

        /* ================= MAIN ================= */

        main{
            margin-left:270px;
            margin-top:75px;
            padding:35px;
            min-height:100vh;
        }

        /* ================= FOOTER ================= */

        .footer{
            margin-left:270px;
            padding:25px;
            border-top:1px solid var(--border);
            background:var(--bg);
            text-align:center;
            color:var(--muted);
        }

        /* ================= DROPDOWN ================= */

        .dropdown-menu{
            background:var(--sidebar);
            border:1px solid var(--border) !important;
            border-radius:18px;
            padding:10px;
            min-width:220px;
        }

        .dropdown-item{
            color:var(--text);
            border-radius:12px;
            font-weight:600;
            padding:12px 14px;
            transition:.2s;
        }

        .dropdown-item:hover{
            background:#334155;
            color:var(--primary);
        }

        .dropdown-divider{
            border-color:#334155;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:992px){
            .sidebar{
                display:none;
            }

            main,
            .footer{
                margin-left:0;
            }

            .navbar-search{
                display:none;
            }

            .navbar-custom{
                padding:0 18px;
            }
        }

        @media(max-width:576px){
            .navbar-brand{
                font-size:1.5rem;
            }

            .profile-name{
                display:none;
            }

            main{
                padding:20px 15px;
            }

            .footer{
                padding:20px 15px;
            }
        }
    </style>

    @guest
        <style>
            main, .footer {
                margin-left: 0 !important;
            }
        </style>
    @endguest

</head>

<body>

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
    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=38bdf8&color=0f172a"
         alt="Profile">
@endif
                    <span class="profile-name">
                        {{ Auth::user()->username }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ url('/profile') }}">
                            <i class="fa fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger"
                           href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-right-from-bracket me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm text-white fw-bold px-3 py-2 rounded-3" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); border: none;">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk
            </a>
        @endauth

    </div>
</nav>

@auth
<aside class="sidebar">
    <div class="sidebar-title">
        Menu Utama
    </div>

    <a href="{{ route('user.dashboard') }}" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>

    <a href="{{ url('/tulis-buku') }}">
        <i class="fa-solid fa-pen-nib"></i> Tulis Buku
    </a>

<a href="{{ route('premium.index') }}"
   class="{{ request()->is('ajukan-premium*') ? 'active' : '' }}">

    <i class="fa-solid fa-crown"></i>
    Ajukan Premium

</a>

    <div class="sidebar-title">
        Koleksi
    </div>

    <a href="{{ route('genre.index') }}">
        <i class="fa-solid fa-book-bookmark"></i> Genre Buku
    </a>

    <a href="{{ route('premium.books') }}"
   class="{{ request()->is('buku-premium*') ? 'active' : '' }}">
    <i class="fa-solid fa-crown"></i>
    Buku Premium
</a>

    <a href="{{ route('favorite.index') }}">
        <i class="fa-regular fa-heart"></i> Buku Favorit
    </a>

    <a href="{{ route('reading.history') }}">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Baca
    </a>

    <a href="{{ route('resume.my') }}" class="{{ request()->is('my-resumes') ? 'active' : '' }}">
        <i class="fa-solid fa-book-open-reader"></i> Resume Saya
    </a>

    <div class="sidebar-title">
        Lainnya
    </div>

    <a href="{{ route('forum.index') }}">
        <i class="fa-solid fa-comments"></i> Forum
    </a>

    <a href="{{ route('reward.index') }}">
        <i class="fa-solid fa-gift"></i> Reward
    </a>
</aside>
@endauth

<main>
    @yield('content')
</main>

<footer class="footer">
    © {{ date('Y') }} Safae. All rights reserved.
</footer>

<form id="logout-form"
      action="{{ route('logout') }}"
      method="POST"
      class="d-none">
    @csrf
</form>

</body>
</html>