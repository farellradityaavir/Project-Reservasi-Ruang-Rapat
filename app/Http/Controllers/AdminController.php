<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'total_users' => User::count(),
            'active_reservations' => Reservation::where('status', 'active')
                ->where('date', '>=', now()->format('Y-m-d'))
                ->count(),
            'today_reservations' => Reservation::where('date', now()->format('Y-m-d'))
                ->where('status', 'active')
                ->count()
        ];

        $recentReservations = Reservation::with(['user', 'room'])
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();

        // HAPUS BARIS INI - tidak perlu mengirim $rooms ke dashboard admin
        // $rooms = Room::withCount(['activeReservations'])->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentReservations'));
    }

    public function reservations()
    {
        $reservations = Reservation::with(['user', 'room'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleRole(User $user)
    {
        // Prevent admin from removing their own admin role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role sendiri.');
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);

        $newRole = $user->role === 'admin' ? 'admin' : 'user';
        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$newRole}.");
    }
}