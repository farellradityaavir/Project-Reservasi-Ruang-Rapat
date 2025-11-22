<?php

use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for room schedule
Route::get('/rooms/{room}/schedule', function (Request $request, $roomId) {
    $date = $request->get('date', now()->format('Y-m-d'));
    
    $reservations = \App\Models\Reservation::with('user')
        ->where('room_id', $roomId)
        ->where('date', $date)
        ->where('status', 'active')
        ->orderBy('start_time', 'asc')
        ->get()
        ->map(function($reservation) {
            return [
                'start_time' => $reservation->start_time,
                'end_time' => $reservation->end_time,
                'user_name' => $reservation->user->name,
                'purpose' => $reservation->purpose
            ];
        });
    
    return response()->json($reservations);
});