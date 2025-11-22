<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function redirect()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        // Redirect ke home page instead of login
        return redirect()->route('home');
    }

    public function userDashboard()
    {
        $user = auth()->user();
        $upcomingReservations = $user->reservations()
            ->with('room')
            ->where('date', '>=', now()->format('Y-m-d'))
            ->where('status', 'active')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();

        $rooms = Room::with(['activeReservations' => function($query) {
            $query->where('date', now()->format('Y-m-d'));
        }])->get();

        return view('user.dashboard', compact('upcomingReservations', 'rooms'));
    }
}