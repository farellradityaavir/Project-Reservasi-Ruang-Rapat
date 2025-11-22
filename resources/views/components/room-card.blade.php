<div class="room-card">
    <div class="room-image">
        <img src="{{ $room->image_url }}" 
             alt="{{ $room->image_alt ?? $room->name }}"
             onerror="this.src='{{ asset('images/default-room.jpg') }}'">
        <div class="room-capacity">{{ $room->capacity }} orang</div>
    </div>
    
    <div class="room-content">
        <h3 class="room-title">{{ $room->name }}</h3>
        <p class="room-location">
            <i class="fas fa-map-marker-alt"></i> {{ $room->location }}
        </p>
        @if($room->description)
        <p class="room-description">{{ Str::limit($room->description, 100) }}</p>
        @endif
        
        <!-- Today's Reservations -->
        @if(isset($room->activeReservations) && $room->activeReservations->count() > 0)
        <div style="margin-top: 1rem;">
            <p style="color: var(--secondary-gray); font-size: 0.8rem; margin-bottom: 0.5rem;">
                <strong>Hari Ini:</strong>
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                @foreach($room->activeReservations as $reservation)
                <span style="background: rgba(255,51,102,0.2); color: var(--accent-red); 
                            padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.7rem;">
                    {{ $reservation->start_time }}
                </span>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="room-actions" style="margin-top: 1.5rem;">
            @if(Route::currentRouteName() === 'admin.rooms.index')
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.rooms.edit', $room) }}" 
                       class="btn btn-secondary btn-sm" style="flex: 1;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                          onsubmit="return confirm('Hapus ruangan ini?')" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('rooms.show', $room) }}" 
                   class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-eye"></i> Lihat Detail & Reservasi
                </a>
            @endif
        </div>
    </div>
</div>