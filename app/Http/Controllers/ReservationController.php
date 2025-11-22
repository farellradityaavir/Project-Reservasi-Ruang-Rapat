<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'nullable|string|max:500'
        ]);

        // Validasi jam kerja
        $validator->after(function ($validator) use ($request) {
            $start = strtotime($request->start_time);
            $end = strtotime($request->end_time);
            
            // Jam kerja: 08:00 - 17:00
            $workStart = strtotime('08:00');
            $workEnd = strtotime('17:00');
            
            if ($start < $workStart || $end > $workEnd) {
                $validator->errors()->add('time', 'Reservasi hanya bisa dilakukan antara jam 08:00 - 17:00');
            }
            
            // Cek bentrok jadwal
            $conflicting = Reservation::where('room_id', $request->room_id)
                ->where('date', $request->date)
                ->where('status', 'active')
                ->where(function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                          ->where('end_time', '>', $request->start_time);
                    });
                })
                ->exists();
                
            if ($conflicting) {
                $validator->errors()->add('time', 'Ruangan sudah dipesan pada jam tersebut');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose
        ]);

        return redirect()->route('user.reservations.index')->with('success', 'Reservasi berhasil dibuat');
    }
}