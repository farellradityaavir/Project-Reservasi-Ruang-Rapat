@props(['schedule'])

<div class="schedule-timeline">
    @foreach($schedule as $reservation)
    <div class="schedule-item">
        <div class="schedule-time">
            {{ $reservation->start_time }} - {{ $reservation->end_time }}
        </div>
        <div class="schedule-user">
            <i class="fas fa-user"></i> {{ $reservation->user->name }}
        </div>
        @if($reservation->purpose)
        <div class="schedule-purpose">
            <i class="fas fa-info-circle"></i> {{ $reservation->purpose }}
        </div>
        @endif
    </div>
    @endforeach
</div>