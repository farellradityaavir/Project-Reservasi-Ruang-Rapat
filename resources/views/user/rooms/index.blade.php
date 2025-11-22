@extends('layouts.app')

@section('title', 'Daftar Ruangan')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="card animate-slide-in-up" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 1rem; flex-wrap: wrap;">
            <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                Daftar Ruangan
            </h1>
            <div style="flex: 1; max-width: 300px;">
                <div style="position: relative;">
                    <input type="text" 
                           id="room-filter" 
                           class="form-control" 
                           placeholder="Cari ruangan..."
                           style="padding-left: 2.5rem;">
                    <i class="fas fa-search" 
                       style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--neutral-400);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    @if($rooms->count() > 0)
        <div class="room-grid">
            @foreach($rooms as $room)
            <div class="room-card card animate-slide-in-up" 
                 style="animation-delay: {{ $loop->index * 0.1 }}s; overflow: hidden;">
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <img src="{{ $room->image_url }}" 
                         alt="{{ $room->image_alt ?? $room->name }}"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjE1MCIgeT0iMTAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiM5OTk5OTkiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=='">
                    <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: var(--primary-red); 
                              color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                        <i class="fas fa-users mr-1"></i>{{ $room->capacity }} orang
                    </div>
                </div>
                
                <div style="padding: 1.25rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.5rem; line-height: 1.4;">
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
                            <i class="fas fa-clock mr-1"></i>Terpakai Hari Ini:
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
                    @else
                    <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--neutral-100);">
                        <p style="font-size: 0.75rem; color: var(--neutral-500); font-weight: 500;">
                            <i class="fas fa-check-circle mr-1" style="color: var(--success);"></i>Tersedia sepanjang hari
                        </p>
                    </div>
                    @endif
                </div>
                
                <div style="padding: 0 1.25rem 1.25rem;">
                    <a href="{{ route('rooms.show', $room) }}" 
                       class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail & Reservasi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; color: var(--neutral-300); margin-bottom: 1rem;">
                <i class="fas fa-door-closed"></i>
            </div>
            <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Tidak ada ruangan tersedia</h3>
            <p style="color: var(--neutral-500);">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
        </div>
    @endif
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

.room-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.room-card {
    transition: all 0.3s ease;
}

.room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
}

.room-card:hover img {
    transform: scale(1.05);
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--neutral-300);
    border-radius: 0.5rem;
    font-family: inherit;
    font-size: 0.875rem;
    color: var(--neutral-800);
    background: white;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }
    
    .room-grid {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .search-container {
        max-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomFilter = document.getElementById('room-filter');
    const roomCards = document.querySelectorAll('.room-card');
    
    if (roomFilter) {
        roomFilter.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            
            roomCards.forEach(card => {
                const roomName = card.querySelector('h3').textContent.toLowerCase();
                const roomLocation = card.querySelector('p').textContent.toLowerCase();
                const roomDescription = card.querySelector('p:nth-child(3)')?.textContent.toLowerCase() || '';
                
                const matches = roomName.includes(filter) || 
                              roomLocation.includes(filter) || 
                              roomDescription.includes(filter);
                
                card.style.display = matches ? 'block' : 'none';
            });
        });
    }

    // Add hover effects
    roomCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.1)';
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
            }
        });
    });
});
</script>
@endsection