<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    // User methods
    public function index()
    {
        $rooms = Room::with(['activeReservations' => function($query) {
            $query->where('date', now()->format('Y-m-d'));
        }])->get();

        return view('user.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        $schedule = $room->activeReservations()
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->with('user')
            ->get();

        $todaySchedule = $room->activeReservations()
            ->where('date', now()->format('Y-m-d'))
            ->orderBy('start_time', 'asc')
            ->with('user')
            ->get();

        return view('user.rooms.show', compact('room', 'schedule', 'todaySchedule'));
    }

    // Admin methods
    public function adminIndex()
    {
        $rooms = Room::withCount(['activeReservations' => function($query) {
            $query->where('date', '>=', now()->format('Y-m-d'));
        }])->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt' => 'nullable|string|max:255'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'location' => $request->location,
            'description' => $request->description,
            'image_path' => $imagePath,
            'image_alt' => $request->image_alt
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:150',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt' => 'nullable|string|max:255'
        ]);

        $data = $request->only(['name', 'capacity', 'location', 'description', 'image_alt']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($room->image_path) {
                Storage::disk('public')->delete($room->image_path);
            }
            $data['image_path'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy(Room $room)
    {
        // Cek apakah ruangan memiliki reservasi aktif
        $hasActiveReservations = $room->activeReservations()
            ->where('date', '>=', now()->format('Y-m-d'))
            ->exists();

        if ($hasActiveReservations) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus ruangan yang memiliki reservasi aktif.');
        }

        // Hapus gambar jika ada
        if ($room->image_path) {
            Storage::disk('public')->delete($room->image_path);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}