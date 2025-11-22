@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-section card animate-slide-in-up" 
         style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%); 
                color: white; padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 2rem;">
            <div style="flex: 1;">
                <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; color: white;">
                    Selamat Datang, {{ auth()->user()->name }}! 
                </h1>
                <p style="color: rgba(255,255,255,0.9); margin: 0;">
                    Kelola reservasi ruang rapat Anda dengan mudah dan efisien.
                </p>
            </div>
            <div style="font-size: 3rem; opacity: 0.8;">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card animate-slide-in-up" style="animation-delay: 0.1s; text-align: center; padding: 1.5rem; position: relative;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $upcomingReservations->count() }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500;" >
                Reservasi Mendatang
            </div>
        </div>
        
        <div class="card animate-slide-in-up" style="animation-delay: 0.2s; text-align: center; padding: 1.5rem; position: relative;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-door-open"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $rooms->count() }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500;">
                Ruangan Tersedia
            </div>
        </div>
    </div>

    <div style="display: grid; gap: 2rem;">
        <!-- Upcoming Reservations -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.3s; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
                <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                    <i class="fas fa-clock mr-3"></i>
                    Reservasi Mendatang
                </h2>
                <a href="{{ route('reservations.index') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if($upcomingReservations->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($upcomingReservations->take(5) as $reservation)
                    <div style="background: white; border-radius: 0.75rem; padding: 1rem; border: 1px solid var(--neutral-200); 
                              border-left: 4px solid var(--primary-red); transition: all 0.2s;">
                        <div style="display: flex; justify-content: between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                                    {{ $reservation->room->name }}
                                </h3>
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--neutral-500); font-size: 0.875rem;">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $reservation->room->location }}
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="color: var(--neutral-600); font-size: 0.875rem; margin-bottom: 0.25rem;">
                                    {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l, d F Y') }}
                                </div>
                                <div style="color: var(--primary-red); font-weight: 600; font-size: 0.875rem;">
                                    {{ $reservation->start_time }} - {{ $reservation->end_time }}
                                </div>
                            </div>
                        </div>
                        
                        @if($reservation->purpose)
                        <div style="color: var(--neutral-500); font-style: italic; font-size: 0.875rem; margin-bottom: 0.75rem; 
                                  padding: 0.5rem 0; border-top: 1px solid var(--neutral-100);">
                            "{{ $reservation->purpose }}"
                        </div>
                        @endif

                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Batalkan reservasi ini?')">
                                    <i class="fas fa-times mr-2"></i>Batalkan
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                    <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--neutral-300);">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Tidak ada reservasi mendatang</h3>
                    <p style="margin-bottom: 1.5rem;">Mulai dengan membuat reservasi pertama Anda.</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-primary">
                        <i class="fas fa-door-open mr-2" ></i>Lihat Ruangan
                    </a>
                </div>
            @endif
        </div>

        <!-- Available Rooms -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.4s; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
                <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                    <i class="fas fa-door-open mr-3"></i>
                    Ruangan Tersedia
                </h2>
                <a href="{{ route('rooms.index') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if($rooms->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @foreach($rooms->take(4) as $room)
                    <div class="card" style="transition: all 0.2s; overflow: hidden;">
                        <div style="position: relative; height: 200px; overflow: hidden;">
                            <img src="{{ $room->image_url }}" 
                                 alt="{{ $room->image_alt ?? $room->name }}"
                                 style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjE1MCIgeT0iMTAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiM5OTk5OTkiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=='">
                            <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: var(--primary-red); 
                                      color: white; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                {{ $room->capacity }} orang
                            </div>
                        </div>
                        
                        <div style="padding: 1rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.5rem;">
                                {{ $room->name }}
                            </h3>
                            <p style="display: flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); font-size: 0.875rem; margin-bottom: 0.75rem;">
                                <i class="fas fa-map-marker-alt"></i> {{ $room->location }}
                            </p>
                            @if($room->description)
                            <p style="color: var(--neutral-500); font-size: 0.875rem; line-height: 1.5; margin-bottom: 1rem;">
                                {{ Str::limit($room->description, 100) }}
                            </p>
                            @endif
                            
                            <!-- Today's Reservations -->
                            @if($room->activeReservations->count() > 0)
                            <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--neutral-100);">
                                <p style="font-size: 0.75rem; color: var(--neutral-500); margin-bottom: 0.5rem; font-weight: 500;">
                                    Jadwal Hari Ini:
                                </p>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                    @foreach($room->activeReservations as $reservation)
                                    <span style="background: var(--primary-red-light); color: var(--primary-red); 
                                               padding: 0.125rem 0.5rem; border-radius: 0.375rem; font-size: 0.7rem; font-weight: 500;">
                                        {{ $reservation->start_time }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div style="padding: 0 1rem 1rem;">
                            <a href="{{ route('rooms.show', $room) }}" 
                               class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-eye mr-2"></i>Lihat Detail & Reservasi
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                    <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--neutral-300);">
                        <i class="fas fa-door-closed"></i>
                    </div>
                    <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Tidak ada ruangan tersedia</h3>
                    <p>Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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

.animate-slide-in-up {
    animation: slideInUp 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }
    
    .welcome-section div {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
        });
    });
});
</script>
@endsection