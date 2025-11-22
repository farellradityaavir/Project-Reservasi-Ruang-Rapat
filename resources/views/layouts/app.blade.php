<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MeetingReserve')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #dc2626;
            --primary-red-dark: #b91c1c;
            --primary-red-light: #fef2f2;
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--neutral-50);
            color: var(--neutral-800);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .app-header {
            background: white;
            border-bottom: 1px solid var(--neutral-200);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
            gap: 2rem;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--neutral-900);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: var(--primary-red);
            color: white;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-accent {
            color: var(--primary-red);
        }

        .nav-main {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--neutral-600);
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-red-light);
            color: var(--primary-red);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-red);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            line-height: 1;
        }

        .btn-primary {
            background: var(--primary-red);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-red-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            color: var(--neutral-700);
            border: 1px solid var(--neutral-300);
        }

        .btn-secondary:hover {
            background: var(--neutral-50);
        }

        .btn-ghost {
            background: transparent;
            color: var(--neutral-600);
        }

        .btn-ghost:hover {
            background: var(--neutral-100);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--neutral-200);
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 70px);
            padding: 2rem 0;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-wrap: wrap;
                height: auto;
                padding: 1rem 0;
            }

            .nav-main {
                order: 3;
                width: 100%;
                margin-top: 1rem;
                justify-content: flex-start;
                overflow-x: auto;
            }

            .container {
                padding: 0 0.75rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <!-- Header -->
    <header class="app-header">
        <div class="container">
            <div class="header-content">
                <!-- Brand -->
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : '/' }}" 
                   class="brand">
                    <div class="brand-logo">
                        <i class="fas fa-video"></i>
                    </div>
                    <span class="brand-text">Ruang<span class="brand-accent">Rapat</span></span>
                </a>

                <!-- Navigation -->
                @auth
                <nav class="nav-main">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.rooms.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <i class="fas fa-door-open"></i>
                            <span>Ruangan</span>
                        </a>
                        <a href="{{ route('admin.reservations') }}" 
                           class="nav-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Reservasi</span>
                        </a>
                        <a href="{{ route('admin.users') }}" 
                           class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Pengguna</span>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('rooms.index') }}" 
                           class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                            <i class="fas fa-door-open"></i>
                            <span>Ruangan</span>
                        </a>
                        <a href="{{ route('reservations.index') }}" 
                           class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                            <i class="fas fa-history"></i>
                            <span>Riwayat</span>
                        </a>
                    @endif
                </nav>

                <!-- User Menu -->
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>