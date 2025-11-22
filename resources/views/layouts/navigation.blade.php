<nav style="background: var(--card-bg); border-bottom: 2px solid var(--accent-red);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0;">
            <div>
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : '/' }}" 
                   style="color: var(--accent-red); text-decoration: none; font-size: 1.5rem; font-weight: bold;">
                   <i class="fas fa-video"></i> RuangRapat
                </a>
            </div>
            
            @auth
            <div style="display: flex; align-items: center; gap: 2rem;">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-door-open"></i> Ruangan
                    </a>
                    <a href="{{ route('admin.reservations') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-calendar-alt"></i> Reservasi
                    </a>
                    <a href="{{ route('admin.users') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-users"></i> Pengguna
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('rooms.index') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-door-open"></i> Ruangan
                    </a>
                    <a href="{{ route('reservations.index') }}" style="color: var(--text-light); text-decoration: none;">
                        <i class="fas fa-history"></i> Riwayat
                    </a>
                @endif
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="color: var(--secondary-gray);">
                        <i class="fas fa-user"></i> {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: var(--secondary-gray); cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>