<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - RuangRapat</title>

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
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--neutral-200);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--neutral-200);
            margin-bottom: 1rem;
        }

        .sidebar-brand h2 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--primary-red);
            font-size: 1.125rem;
            font-weight: 700;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-nav li {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--neutral-600);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: var(--primary-red);
            color: white;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--neutral-200);
            margin: 1rem 0;
        }

        .sidebar-logout {
            width: 100%;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--neutral-600);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .sidebar-link:hover {
            background: var(--neutral-100);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        .admin-topbar {
            background: white;
            border-bottom: 1px solid var(--neutral-200);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .admin-topbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .mobile-menu-toggle {
            display: none;
        }

        .admin-breadcrumb {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--neutral-900);
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .admin-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
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

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Animations */
        .animate-slide-in-up {
            animation: slideInUp 0.3s ease;
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-content {
                padding: 1rem;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .admin-topbar {
                padding: 0 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <h2>
                    <i class="fas fa-cogs"></i>
                    Admin Panel
                </h2>
            </div>
            
            <nav>
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rooms.index') }}" 
                           class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <i class="fas fa-door-open"></i>
                            <span>Kelola Ruangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations') }}" 
                           class="{{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Kelola Reservasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" 
                           class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Kelola Pengguna</span>
                        </a>
                    </li>
                    <li class="sidebar-divider"></li>
                    <li>
                        <a href="{{ route('user.dashboard') }}">
                            <i class="fas fa-user"></i>
                            <span>Mode User</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
                            @csrf
                            <button type="submit" class="sidebar-link">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <div class="admin-topbar-content">
                    <button class="mobile-menu-toggle btn btn-ghost btn-sm">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="admin-breadcrumb">
                        @yield('breadcrumb', 'Dashboard')
                    </div>
                    
                    <div class="admin-user-menu">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success animate-slide-in-up">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error animate-slide-in-up">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');
            
            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>   