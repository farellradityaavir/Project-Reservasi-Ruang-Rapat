@extends('layouts.app')

@section('title', 'Buat Reservasi - ' . $room->name)

@section('content')
<div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Room Info -->
        <div class="card animate-slide-in-up">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--neutral-200);">
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                    {{ $room->name }}
                </h1>
                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--neutral-500);">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $room->location }}</span>
                </div>
            </div>
            
            <div style="padding: 1.5rem;">
                <div style="margin-bottom: 1.5rem;">
                    <img src="{{ $room->image_url }}" 
                         alt="{{ $room->image_alt ?? $room->name }}"
                         style="width: 100%; height: 200px; object-fit: cover; border-radius: 0.5rem;"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjE1MCIgeT0iMTAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTgiIGZpbGw9IiM5OTk5OTkiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=='">
                </div>

                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; align-items: center; justify-content: between;">
                        <span style="font-weight: 500; color: var(--neutral-700);">Kapasitas</span>
                        <span style="color: var(--neutral-600);">
                            <i class="fas fa-users mr-1"></i>{{ $room->capacity }} orang
                        </span>
                    </div>
                    
                    @if($room->description)
                    <div>
                        <span style="font-weight: 500; color: var(--neutral-700); display: block; margin-bottom: 0.5rem;">Deskripsi</span>
                        <p style="color: var(--neutral-600); margin: 0; line-height: 1.5;">{{ $room->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reservation Form -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.1s;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--neutral-200);">
                <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                    <i class="fas fa-calendar-plus mr-3"></i>
                    Form Reservasi
                </h2>
            </div>

            <div style="padding: 1.5rem;">
                <form id="reservation-form" method="POST" action="{{ route('reservations.store') }}">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="date">
                            <i class="fas fa-calendar-day mr-2"></i>Tanggal Reservasi *
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="date" 
                               name="date" 
                               value="{{ old('date', now()->format('Y-m-d')) }}"
                               min="{{ now()->format('Y-m-d') }}" 
                               required>
                        @error('date')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label class="form-label" for="start_time">
                                <i class="fas fa-clock mr-2"></i>Jam Mulai *
                            </label>
                            <input type="time" 
                                   class="form-control" 
                                   id="start_time" 
                                   name="start_time" 
                                   value="{{ old('start_time', '08:00') }}"
                                   min="08:00" 
                                   max="17:00" 
                                   required>
                        </div>

                        <div>
                            <label class="form-label" for="end_time">
                                <i class="fas fa-clock mr-2"></i>Jam Selesai *
                            </label>
                            <input type="time" 
                                   class="form-control" 
                                   id="end_time" 
                                   name="end_time" 
                                   value="{{ old('end_time', '09:00') }}"
                                   min="08:00" 
                                   max="17:00" 
                                   required>
                        </div>
                    </div>

                    @error('time')
                        <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <div style="margin-bottom: 2rem;">
                        <label class="form-label" for="purpose">
                            <i class="fas fa-bullseye mr-2"></i>Tujuan Rapat
                        </label>
                        <textarea class="form-control" 
                                  id="purpose" 
                                  name="purpose" 
                                  rows="4" 
                                  placeholder="Deskripsikan tujuan rapat Anda...">{{ old('purpose') }}</textarea>
                        <div style="color: var(--neutral-500); font-size: 0.75rem; margin-top: 0.5rem;">
                            Opsional, namun disarankan untuk mengisi tujuan rapat
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary" style="flex: 1;">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex: 2;">
                            <i class="fas fa-calendar-check mr-2"></i>Buat Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    @if($schedule->count() > 0)
    <div class="card animate-slide-in-up" style="animation-delay: 0.2s; margin-top: 2rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--neutral-200);">
            <h3 style="display: flex; align-items: center; font-size: 1.125rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                <i class="fas fa-calendar-day mr-3"></i>
                Jadwal Hari Ini
            </h3>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: grid; gap: 0.75rem;">
                @foreach($schedule as $reservation)
                <div style="background: var(--primary-red-light); border: 1px solid rgba(220, 38, 38, 0.2); 
                          border-radius: 0.5rem; padding: 1rem;">
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
        </div>
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
    
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const dateInput = document.getElementById('date');
    const form = document.getElementById('reservation-form');

    function validateTimes() {
        if (startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                showError('Waktu selesai harus setelah waktu mulai.');
                endTime.focus();
                return false;
            }
            
            // Business hours validation (08:00 - 17:00)
            if (startTime.value < '08:00' || endTime.value > '17:00') {
                showError('Reservasi hanya dapat dilakukan antara jam 08:00 - 17:00.');
                startTime.focus();
                return false;
            }
        }
        return true;
    }

    function showError(message) {
        // Remove existing error alerts
        const existingAlert = document.querySelector('.alert-error');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Create new error alert
        const alert = document.createElement('div');
        alert.className = 'alert alert-error';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle mr-2"></i>${message}
        `;
        
        // Insert after time inputs
        const timeInputsContainer = startTime.parentElement.parentElement;
        timeInputsContainer.parentNode.insertBefore(alert, timeInputsContainer.nextSibling);
    }

    function clearError() {
        const existingAlert = document.querySelector('.alert-error');
        if (existingAlert && !existingAlert.hasAttribute('data-server-error')) {
            existingAlert.remove();
        }
    }

    startTime.addEventListener('change', function() {
        clearError();
        validateTimes();
        
        // Set minimum for end time
        if (this.value) {
            endTime.min = this.value;
        }
    });

    endTime.addEventListener('change', function() {
        clearError();
        validateTimes();
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateTimes()) {
            e.preventDefault();
            return;
        }
        
        // Check if date is in the past
        const selectedDate = new Date(dateInput.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            e.preventDefault();
            showError('Tidak dapat membuat reservasi untuk tanggal yang sudah lewat.');
            dateInput.focus();
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds if still on page (form submission failed)
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }, 3000);
    });

    // Mark server-side errors
    const serverError = document.querySelector('.alert-error');
    if (serverError) {
        serverError.setAttribute('data-server-error', 'true');
    }

    // Auto-set end time if only start time is provided
    startTime.addEventListener('change', function() {
        if (this.value && !endTime.value) {
            // Add 1 hour to start time
            const [hours, minutes] = this.value.split(':').map(Number);
            let endHours = hours + 1;
            if (endHours > 17) endHours = 17;
            
            const endTimeString = `${endHours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            endTime.value = endTimeString;
        }
    });
});
</script>
@endsection