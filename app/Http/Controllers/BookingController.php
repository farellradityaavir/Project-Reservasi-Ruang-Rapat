<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Dashboard User
    public function userDashboard()
    {
        $rooms = Room::all();
        return view('user.dashboard', compact('rooms'));
    }

    // Riwayat Reservasi
    public function history()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('user.history', compact('bookings'));
    }

    // HALAMAN BARU: Batalkan Booking oleh User
    public function cancel(Booking $booking)
    {
        // 1. Pastikan booking ini milik user yang sedang login
        if ($booking->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        // 2. Pastikan jadwal belum lewat (Hanya bisa batal jika waktu belum berlalu)
        $bookingTime = Carbon::parse($booking->tanggal . ' ' . $booking->jam_mulai);
        
        if ($bookingTime->isPast()) {
            return redirect()->back()->with('error', 'Booking yang sudah lewat tidak dapat dibatalkan.');
        }

        // 3. Hapus data
        $booking->delete();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    // Form Booking
    public function showBookingForm(Room $room)
    {
        return view('booking.form', compact('room'));
    }

    // Proses Simpan Booking
    public function bookRoom(Request $request, Room $room)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek Ketersediaan
        $isBooked = Booking::where('room_id', $room->id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($isBooked) {
            return back()
                ->withErrors(['jam_mulai' => 'Ruangan penuh di jam tersebut.'])
                ->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('user.history')->with('success', 'Booking berhasil dibuat!');
    }
}