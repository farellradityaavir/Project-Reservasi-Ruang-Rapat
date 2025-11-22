@extends('layouts.admin')

@section('title', 'Kelola Ruangan')
@section('breadcrumb', 'Kelola Ruangan')

@section('content')
<div class="admin-rooms">
    <!-- Header -->
    <div class="card animate-slide-in-up" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 1rem; flex-wrap: wrap;">
            <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                Kelola Ruangan
            </h1>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Ruangan
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="flex: 1; max-width: 300px;">
                <div style="position: relative;">
                    <input type="text" 
                           id="room-search" 
                           class="form-control" 
                           placeholder="Cari ruangan..."
                           style="padding-left: 2.5rem;">
                    <i class="fas fa-search" 
                       style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--neutral-400);"></i>
                </div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn btn-secondary btn-sm" onclick="resetFilters()">
                    <i class="fas fa-refresh mr-1"></i>Reset
                </button>
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
                    
                    <!-- Reservation Stats -->
                    <div style="display: flex; align-items: center; justify-content: between; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--neutral-100);">
                        <span style="font-size: 0.75rem; color: var(--neutral-500);">
                            <i class="fas fa-calendar-check mr-1"></i>
                            {{ $room->active_reservations_count }} reservasi aktif
                        </span>
                    </div>
                </div>
                
                <div style="padding: 0 1.25rem 1.25rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.rooms.edit', $room) }}" 
                           class="btn btn-secondary btn-sm" style="flex: 1;">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm w-full"
                                    onclick="return confirm('Hapus ruangan {{ $room->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($rooms->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                @if($rooms->onFirstPage())
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
                @else
                <a href="{{ $rooms->previousPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-left"></i>
                </a>
                @endif

                @foreach($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                    @if($page == $rooms->currentPage())
                    <span class="btn btn-primary btn-sm" style="min-width: 2.5rem;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="btn btn-ghost btn-sm" style="min-width: 2.5rem;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($rooms->hasMorePages())
                <a href="{{ $rooms->nextPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-right"></i>
                </a>
                @else
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
                @endif
            </div>
        </div>
        @endif
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; color: var(--neutral-300); margin-bottom: 1rem;">
                <i class="fas fa-door-closed"></i>
            </div>
            <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Belum ada ruangan</h3>
            <p style="color: var(--neutral-500); margin-bottom: 1.5rem;">Mulai dengan menambahkan ruangan pertama.</p>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Ruangan Pertama
            </a>
        </div>
    @endif
</div>

<style>
.admin-rooms {
    max-width: 1200px;
    margin: 0 auto;
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

.btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .room-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-container {
        max-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSearch = document.getElementById('room-search');
    const roomCards = document.querySelectorAll('.room-card');
    
    if (roomSearch) {
        roomSearch.addEventListener('input', function() {
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

function resetFilters() {
    const searchInput = document.getElementById('room-search');
    if (searchInput) {
        searchInput.value = '';
    }
    
    const roomCards = document.querySelectorAll('.room-card');
    roomCards.forEach(card => {
        card.style.display = 'block';
    });
}
</script>
@endsection