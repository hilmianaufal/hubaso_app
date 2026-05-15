<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HUBASO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .main-wrapper {
            min-height: 100vh;
        }

        .modern-navbar {
            position: sticky;
            top: 0;
            z-index: 9999;
            backdrop-filter: blur(12px);
            background: linear-gradient(135deg, #2563eb, #3b82f6, #60a5fa);
            padding: 12px 0;
            box-shadow: 0 10px 30px rgba(37,99,235,0.18);
        }

        .navbar-brand {
            font-weight: 800;
            color: white !important;
            font-size: 24px;
            white-space: nowrap;
        }

        .navbar-nav {
            gap: 8px;
        }

        .navbar-nav .nav-link {
            position: relative;
            overflow: hidden;
            color: white !important;
            font-weight: 600;
            padding: 11px 15px;
            border-radius: 16px;
            transition: all .25s ease;
            display: flex;
            align-items: center;
            gap: 7px;
            z-index: 1;
            white-space: nowrap;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(
                135deg,
                rgba(255,255,255,0.20),
                rgba(255,255,255,0.06)
            );
            opacity: 0;
            transition: .25s;
            z-index: -1;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -120%;
            width: 70px;
            height: 220%;
            background: rgba(255,255,255,0.25);
            transform: rotate(25deg);
            transition: .5s;
        }

        .navbar-nav .nav-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(255,255,255,0.15);
        }

        .navbar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .navbar-nav .nav-link:hover::after {
            left: 140%;
        }

        .navbar-nav .nav-link.active {
            background: linear-gradient(
                135deg,
                rgba(255,255,255,0.30),
                rgba(255,255,255,0.12)
            );
            font-weight: 700;
            box-shadow:
                0 0 18px rgba(255,255,255,0.22),
                0 0 35px rgba(96,165,250,0.35);
            animation: glowPulse 2s infinite;
        }

        .navbar-nav .nav-link i {
            font-size: 17px;
        }

        @keyframes glowPulse {
            0% {
                box-shadow:
                    0 0 10px rgba(255,255,255,0.12),
                    0 0 20px rgba(96,165,250,0.2);
            }

            50% {
                box-shadow:
                    0 0 18px rgba(255,255,255,0.28),
                    0 0 38px rgba(96,165,250,0.45);
            }

            100% {
                box-shadow:
                    0 0 10px rgba(255,255,255,0.12),
                    0 0 20px rgba(96,165,250,0.2);
            }
        }

        .btn-logout {
            border-radius: 16px;
            padding: 11px 18px;
            font-weight: 700;
            white-space: nowrap;
        }

        .content-wrapper {
            padding: 30px 0;
        }

        .content-card {
            background: white;
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            min-height: 80vh;
        }

        /* TABLET */
        @media (max-width: 1200px) {
            .navbar .container {
                align-items: flex-start;
            }

            .navbar-nav {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                width: 100%;
            }

            .navbar-nav .nav-link {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                min-width: 82px;
                min-height: 68px;
                padding: 9px 10px !important;
                font-size: 12px;
                line-height: 1.2;
                gap: 5px;
            }

            .navbar-nav .nav-link i {
                font-size: 18px;
            }

            .navbar-nav .nav-link span {
                display: block;
            }

            .btn-logout {
                min-height: 68px;
                padding: 10px 16px;
            }
        }

        /* MOBILE */
        @media(max-width: 991px) {
            .navbar-collapse {
                margin-top: 16px;
                background: rgba(255,255,255,0.12);
                padding: 14px;
                border-radius: 22px;
            }

            .navbar-nav {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .navbar-nav .nav-link {
                min-width: auto;
                width: 100%;
                min-height: 72px;
                font-size: 12px;
                padding: 10px 8px !important;
            }

            .navbar-nav .nav-link i {
                font-size: 20px;
            }

            .nav-logout {
                grid-column: 1 / -1;
            }

            .btn-logout {
                width: 100%;
                min-height: auto;
            }

            .content-card {
                padding: 18px;
            }
        }

        @media(max-width: 576px) {
            .navbar-brand {
                font-size: 21px;
            }

            .navbar-nav {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-wrapper {
                padding: 18px 0;
            }

            .content-card {
                border-radius: 22px;
            }

            .dropdown-menu {
                padding: 10px;
            }

            .dropdown-item {
                border-radius: 12px;
                padding: 10px 14px;
                font-weight: 600;
            }

            .dropdown-item:hover {
                background: #eff6ff;
                color: #2563eb;
            }

            .dropdown-item.active {
                background: #2563eb;
                color: white;
            }
        }
    </style>

    <link rel="manifest" href="/manifest.json">

<meta name="theme-color" content="#2563eb">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="HUBASO">
</head>
<body>

<div class="main-wrapper">

    <nav class="navbar navbar-expand-lg modern-navbar">

        <div class="container">

            <a class="navbar-brand"
               href="/dashboard">
                🍜 HUBASO
            </a>

            <button class="navbar-toggler bg-white"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse"
                 id="navbarMenu">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    @if(in_array(auth()->user()->role, ['owner', 'admin']))

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                               href="/dashboard">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"
                               href="/categories">
                                <i class="bi bi-tags"></i>
                                <span>Kategori</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('menus*') ? 'active' : '' }}"
                               href="/menus">
                                <i class="bi bi-cup-hot"></i>
                                <span>Menu</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('tables*') ? 'active' : '' }}"
                               href="/tables">
                                <i class="bi bi-grid"></i>
                                <span>Meja</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}"
                               href="/reports">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Laporan</span>
                            </a>
                        </li>

                        <li class="nav-item">
                         <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}"
                            href="/users">
                                <i class="bi bi-people"></i>
                                <span>User</span>
                            </a>
                        </li>
                        

                    @endif

                    @if(in_array(auth()->user()->role, ['owner', 'admin', 'kasir']))

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle {{ request()->is('kasir*') ? 'active' : '' }}"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                            <i class="bi bi-cash-stack"></i>
                            <span>Kasir</span>

                        </a>

                        <ul class="dropdown-menu border-0 shadow rounded-4">

                            <li>
                                <a class="dropdown-item {{ request()->is('kasir/dashboard') ? 'active' : '' }}"
                                href="/kasir/dashboard">
                                    💳 Dashboard Kasir
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->is('kasir/manual-order') ? 'active' : '' }}"
                                href="/kasir/manual-order">
                                    📝 Input Order
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item {{ request()->is('kasir/orders*') ? 'active' : '' }}"
                                href="/kasir/orders">
                                    🧾 Order Masuk
                                </a>
                            </li>

                        </ul>

                    </li>

                    @endif

                    @if(in_array(auth()->user()->role, ['owner', 'admin', 'dapur']))

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kitchen*') ? 'active' : '' }}"
                               href="/kitchen">
                                <i class="bi bi-fire"></i>
                                <span>Dapur</span>
                            </a>
                        </li>
                    @endif
             @if(in_array(auth()->user()->role, ['dapur']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('menus*') ? 'active' : '' }}"
                               href="/menus">
                                <i class="bi bi-cup-hot"></i>
                                <span>Menu</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item ms-lg-2 nav-logout">

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <button class="btn btn-dark btn-logout">
                                Logout
                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="content-wrapper">

        <div class="container">

            <div class="content-card">

                @yield('content')

                {{ $slot ?? '' }}

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js')
                .then(function () {
                    console.log('HUBASO PWA aktif');
                })
                .catch(function (error) {
                    console.log('PWA gagal:', error);
                });
        });
    }
</script>
</body>
</html>