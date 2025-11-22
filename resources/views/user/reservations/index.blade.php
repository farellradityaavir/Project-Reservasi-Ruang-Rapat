@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="card animate-slide-in-up" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 1rem; flex-wrap: wrap;">
            <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                Riwayat Reservasi Saya
            </h1>
            <div style="color: var(--neutral-500); font-size: 0.875rem;">
                Total: {{ $reservations->total() }} reservasi
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="flex: 1; max-width: 300px;">
                <div style="position: relative;">
                    <input type="text" 
                           id="reservation-search" 
                           class="form-control" 
                           placeholder="Cari reservasi..."
                           style="padding-left: 2.5rem;">
                    <i class="fas fa-search" 
                       style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--neutral-400);"></i>
                </div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <select id="status-filter" class="form-control" style="max-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                <button class="btn btn-secondary btn-sm" onclick="resetFilters()">
                    <i class="fas fa-refresh mr-1"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Reservations List -->
    @if($reservations->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($reservations as $reservation)
            <div class="reservation-card card animate-slide-in-up {{ $reservation->status === 'cancelled' ? 'cancelled' : 'active' }}" 
                 style="animation-delay: {{ $loop->index * 0.1 }}s;"
                 data-status="{{ $reservation->status }}"
                 data-search="{{ strtolower($reservation->room->name . ' ' . $reservation->purpose) }}">
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: center;">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                            {{ $reservation->room->name }}
                        </h3>
                        <p style="display: flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); font-size: 0.875rem; margin: 0;">
                            <i class="fas fa-map-marker-alt"></i> {{ $reservation->room->location }}
                        </p>
                        @if($reservation->purpose)
                        <p style="color: var(--neutral-500); font-style: italic; font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                            "{{ $reservation->purpose }}"
                        </p>
                        @endif
                    </div>

                    <div>
                        <div style="font-weight: 500; color: var(--neutral-700); font-size: 0.875rem;">Tanggal</div>
                        <div style="color: var(--neutral-600); font-size: 0.875rem;">
                            {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}
                        </div>
                    </div>

                    <div>
                        <div style="font-weight: 500; color: var(--neutral-700); font-size: 0.875rem;">Waktu</div>
                        <div style="color: var(--primary-red); font-weight: 600; font-size: 0.875rem;">
                            {{ $reservation->start_time }} - {{ $reservation->end_time }}
                        </div>
                    </div>

                    <div style="text-align: right;">
                        @if($reservation->status === 'active' && $reservation->date >= now()->format('Y-m-d'))
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Batalkan reservasi ini?')">
                                <i class="fas fa-times mr-1"></i>Batalkan
                            </button>
                        </form>
                        @else
                        <span class="status-badge {{ $reservation->status }}">
                            @if($reservation->status === 'cancelled')
                            <i class="fas fa-times-circle mr-1"></i>Dibatalkan
                            @else
                            <i class="fas fa-check-circle mr-1"></i>Selesai
                            @endif
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Mobile View -->
                <div style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--neutral-200);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <div style="font-weight: 500; color: var(--neutral-700); font-size: 0.875rem;">Tanggal</div>
                            <div style="color: var(--neutral-600); font-size: 0.875rem;">
                                {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}
                            </div>
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--neutral-700); font-size: 0.875rem;">Waktu</div>
                            <div style="color: var(--primary-red); font-weight: 600; font-size: 0.875rem;">
                                {{ $reservation->start_time }} - {{ $reservation->end_time }}
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; text-align: center;">
                        @if($reservation->status === 'active' && $reservation->date >= now()->format('Y-m-d'))
                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Batalkan reservasi ini?')">
                                <i class="fas fa-times mr-1"></i>Batalkan
                            </button>
                        </form>
                        @else
                        <span class="status-badge {{ $reservation->status }}">
                            @if($reservation->status === 'cancelled')
                            <i class="fas fa-times-circle mr-1"></i>Dibatalkan
                            @else
                            <i class="fas fa-check-circle mr-1"></i>Selesai
                            @endif
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reservations->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                @if($reservations->onFirstPage())
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
                @else
                <a href="{{ $reservations->previousPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-left"></i>
                </a>
                @endif

                @foreach($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                    @if($page == $reservations->currentPage())
                    <span class="btn btn-primary btn-sm" style="min-width: 2.5rem;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="btn btn-ghost btn-sm" style="min-width: 2.5rem;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($reservations->hasMorePages())
                <a href="{{ $reservations->nextPageUrl() }}" class="btn btn-ghost btn-sm">
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
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Belum ada reservasi</h3>
            <p style="color: var(--neutral-500); margin-bottom: 1.5rem;">Mulai dengan membuat reservasi pertama Anda.</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-primary">
                <i class="fas fa-door-open mr-2"></i>Lihat Ruangan
            </a>
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

.reservation-card {
    padding: 1.5rem;
    border-left: 4px solid var(--primary-red);
    transition: all 0.2s;
}

.reservation-card.cancelled {
    border-left-color: var(--neutral-400);
    opacity: 0.7;
}

.reservation-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.cancelled {
    background: #f3f4f6;
    color: #6b7280;
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
    .container {
        padding: 0 0.75rem;
    }
    
    .reservation-card > div:first-child {
        display: none;
    }
    
    .reservation-card > div:last-child {
        display: block;
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
    const searchInput = document.getElementById('reservation-search');
    const statusFilter = document.getElementById('status-filter');
    const reservationCards = document.querySelectorAll('.reservation-card');
    
    function filterReservations() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value : '';
        
        reservationCards.forEach(card => {
            const searchData = card.getAttribute('data-search');
            const cardStatus = card.getAttribute('data-status');
            
            const matchesSearch = searchData.includes(searchTerm);
            const matchesStatus = !statusValue || cardStatus === statusValue;
            
            card.style.display = (matchesSearch && matchesStatus) ? 'block' : 'none';
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', filterReservations);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterReservations);
    }

    // Add hover effects
    reservationCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 6px -1px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Mobile view detection
    function checkMobileView() {
        const isMobile = window.innerWidth <= 768;
        reservationCards.forEach(card => {
            const desktopView = card.querySelector('div:first-child');
            const mobileView = card.querySelector('div:last-child');
            
            if (isMobile) {
                desktopView.style.display = 'none';
                mobileView.style.display = 'block';
            } else {
                desktopView.style.display = 'grid';
                mobileView.style.display = 'none';
            }
        });
    }
    
    checkMobileView();
    window.addEventListener('resize', checkMobileView);
});

function resetFilters() {
    const searchInput = document.getElementById('reservation-search');
    const statusFilter = document.getElementById('status-filter');
    
    if (searchInput) searchInput.value = '';
    if (statusFilter) statusFilter.value = '';
    
    const reservationCards = document.querySelectorAll('.reservation-card');
    reservationCards.forEach(card => {
        card.style.display = 'block';
    });
}
</script>
@endsection