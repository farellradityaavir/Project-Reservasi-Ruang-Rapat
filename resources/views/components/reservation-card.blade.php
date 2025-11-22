@props(['reservation'])

<div class="reservation-card {{ $reservation->status === 'cancelled' ? 'cancelled' : '' }}">
    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: center;">
        <div>
            <h3 style="color: var(--text-light); margin-bottom: 0.25rem;">
                {{ $reservation->room->name }}
            </h3>
            <p style="color: var(--secondary-gray); margin: 0;">
                <i class="fas fa-map-marker-alt"></i> {{ $reservation->room->location }}
            </p>
            @if($reservation->purpose)
            <p style="color: var(--secondary-gray); font-style: italic; margin: 0.25rem 0 0 0;">
                "{{ $reservation->purpose }}"
            </p>
            @endif
        </div>

        <div>
            <strong style="color: var(--text-light);">Tanggal</strong>
            <p style="color: var(--secondary-gray); margin: 0;">
                {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}
            </p>
        </div>

        <div>
            <strong style="color: var(--text-light);">Waktu</strong>
            <p style="color: var(--accent-red); font-weight: bold; margin: 0;">
                {{ $reservation->start_time }} - {{ $reservation->end_time }}
            </p>
        </div>

        <div style="text-align: right;">
            @if($reservation->status === 'active' && $reservation->date >= now()->format('Y-m-d'))
            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Batalkan reservasi ini?')">
                    <i class="fas fa-times"></i> Batalkan
                </button>
            </form>
            @else
            <span class="status-badge {{ $reservation->status }}">
                {{ $reservation->status === 'cancelled' ? 'Dibatalkan' : 'Selesai' }}
            </span>
            @endif
        </div>
    </div>
</div>