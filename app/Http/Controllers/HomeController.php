<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua ruangan tanpa filter status (karena kolom status tidak ada)
        $rooms = Room::orderBy('name', 'asc')->get();
        
        return view('home', compact('rooms'));
    }
}