@extends('layouts.app')

@section('title', $room->name)

@section('content')
<div class="container">
    <!-- Room Header -->
    <div class="card animate-slide-in-up" style="padding: 0; overflow: hidden;">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 0; min-height: 300px;">
            <div style="position: relative;">
                <img src="{{ $room->image_url }}" 
                     alt="{{ $room->image_alt ?? $room->name }}"
                     style="width: 100%; height: 100%; object-fit: cover;"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjE1MCIgeT0iMTAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiM5OTk5OTkiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=='">
            </div>
            <div style="padding: 2rem;">
                <div style="display: flex; align-items: start; justify-content: between; margin-bottom: 1rem;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                        {{ $room->name }}
                    </h1>
                    <div style="background: var(--primary-red); color: white; padding: 0.5rem 1rem; 
                              border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                        <i class="fas fa-users mr-1"></i>{{ $room->capacity }} orang
                    </div>
                </div>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 2rem; height: 2rem; background: var(--primary-red-light); color: var(--primary-red);
                                  border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--neutral-700);">Lokasi</div>
                            <div style="color: var(--neutral-600);">{{ $room->location }}</div>
                        </div>
                    </div>
                    
                    @if($room->description)
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <div style="width: 2rem; height: 2rem; background: var(--primary-red-light); color: var(--primary-red);
                                  border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; margin-top: 0.25rem;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <div style="font-weight: 500; color: var(--neutral-700); margin-bottom: 0.5rem;">Deskripsi</div>
                            <div style="color: var(--neutral-600); line-height: 1.6;">{{ $room->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <!-- Today's Schedule -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 1.5rem;">
            <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 1rem;">
                <i class="fas fa-calendar-day mr-3" style="margin-right: 10px;"></i>
                Jadwal Hari Ini
            </h2>
            
            @if($todaySchedule->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($todaySchedule as $reservation)
                    <div style="background: var(--primary-red-light); border: 1px solid rgba(220, 38, 38, 0.2); 
                              border-radius: 0.5rem; padding: 1rem; transition: all 0.2s;">
                        <div style="color: var(--primary-red); font-weight: 600; font-size: 0.875rem; margin-bottom: 0.25rem;">
                            {{ $reservation->start_time }} - {{ $reservation->end_time }}
                        </div>
                        <div style="color: var(--neutral-700); font-size: 0.875rem; font-weight: 500;">
                            {{ $reservation->user->name }}
                        </div>
                        @if($reservation->purpose)
                        <div style="color: var(--neutral-500); font-size: 0.75rem; margin-top: 0.5rem; font-style: italic;">
                            {{ $reservation->purpose }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--neutral-300);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <p style="margin: 0;">Tidak ada reservasi untuk hari ini</p>
                </div>
            @endif
        </div>

        <!-- Reservation Form -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.2s; padding: 1.5rem;">
            <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 1rem;">
                <i class="fas fa-plus-circle mr-3"  style="margin-right: 10px;"></i>
                Buat Reservasi
            </h2>

            <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div style="margin-bottom: 1rem;">
                    <label class="form-label" for="date">Tanggal Reservasi</label>
                    <input type="date" 
                           class="form-control" 
                           id="date" 
                           name="date" 
                           min="{{ now()->format('Y-m-d') }}" 
                           required>
                    @error('date')
                        <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                    <div>
                        <label class="form-label" for="start_time">Jam Mulai</label>
                        <input type="time" 
                               class="form-control" 
                               id="start_time" 
                               name="start_time" 
                               min="08:00" 
                               max="17:00" 
                               required>
                    </div>

                    <div>
                        <label class="form-label" for="end_time">Jam Selesai</label>
                        <input type="time" 
                               class="form-control" 
                               id="end_time" 
                               name="end_time" 
                               min="08:00" 
                               max="17:00" 
                               required>
                    </div>
                </div>

                @error('time')
                    <div class="alert alert-error" style="margin-bottom: 1rem;">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $message }}
                    </div>
                @enderror

                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" for="purpose">Tujuan Rapat</label>
                    <textarea class="form-control" 
                              id="purpose" 
                              name="purpose" 
                              rows="3" 
                              placeholder="Deskripsikan tujuan rapat Anda..."
                              style="resize: vertical; min-height: 80px;"></textarea>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary" style="flex: 1;">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex: 2;">
                        <i class="fas fa-calendar-check mr-2"></i>Buat Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Upcoming Schedule -->
    <div class="card animate-slide-in-up" style="animation-delay: 0.3s; padding: 1.5rem; margin-top: 2rem;">
        <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 1rem;">
            <i class="fas fa-calendar-alt mr-3"  style="margin-right: 10px;"></i>
            Jadwal Mendatang
        </h2>
        
        @if($schedule->count() > 0)
            <div style="display: grid; gap: 1.5rem;">
                @foreach($schedule->groupBy('date') as $date => $reservations)
                <div>
                    <h3 style="color: var(--neutral-900); margin-bottom: 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--neutral-200);">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                    </h3>
                    <div style="display: grid; gap: 0.75rem;">
                        @foreach($reservations as $reservation)
                        <div style="background: var(--neutral-50); border-radius: 0.5rem; padding: 1rem;">
                            <div style="display: flex; align-items: center; justify-content: between;">
                                <div>
                                    <div style="color: var(--primary-red); font-weight: 600; font-size: 0.875rem;">
                                        {{ $reservation->start_time }} - {{ $reservation->end_time }}
                                    </div>
                                    <div style="color: var(--neutral-700); font-size: 0.875rem; margin-top: 0.25rem;">
                                        {{ $reservation->user->name }}
                                    </div>
                                </div>
                                <div style="color: var(--neutral-500); font-size: 0.75rem;">
                                    {{ $reservation->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @if($reservation->purpose)
                            <div style="color: var(--neutral-500); font-size: 0.75rem; margin-top: 0.5rem; font-style: italic;">
                                "{{ $reservation->purpose }}"
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--neutral-500);">
                <div style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--neutral-300);">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <p style="margin: 0;">Tidak ada reservasi mendatang</p>
            </div>
        @endif
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

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--neutral-700);
    font-size: 0.875rem;
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

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
}

.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fecaca;
}

@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }
    
    .room-header {
        grid-template-columns: 1fr;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    function validateTimes() {
        if (startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                alert('Waktu selesai harus setelah waktu mulai.');
                endTime.value = '';
                endTime.focus();
                return false;
            }
            
            // Business hours validation
            if (startTime.value < '08:00' || endTime.value > '17:00') {
                alert('Reservasi hanya dapat dilakukan antara jam 08:00 - 17:00.');
                startTime.value = '';
                endTime.value = '';
                startTime.focus();
                return false;
            }
        }
        return true;
    }

    startTime.addEventListener('change', validateTimes);
    endTime.addEventListener('change', validateTimes);

    // Form submission validation
    const form = document.getElementById('reservation-form');
    form.addEventListener('submit', function(e) {
        if (!validateTimes()) {
            e.preventDefault();
        }
    });

    // Set minimum time for end time based on start time
    startTime.addEventListener('change', function() {
        if (this.value) {
            endTime.min = this.value;
        }
    });
});
</script>
@endsection