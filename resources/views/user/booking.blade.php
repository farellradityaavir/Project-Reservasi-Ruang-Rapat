@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4">
            <h2 class="text-white text-xl font-bold">Form Booking: {{ $room->nama }}</h2>
        </div>
        
        <div class="p-6">
            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.submit', $room->id) }}" method="POST">
                @csrf
                
                <!-- Nama & HP (Otomatis terisi data user login, tapi bisa diedit) -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Peminjam</label>
                    <input type="text" name="nama" value="{{ old('nama', Auth::user()->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nomor HP / WA</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500" required placeholder="0812xxxx">
                </div>

                <hr class="my-4 border-gray-200">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Booking</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500" required>
                </div>

                <div class="flex space-x-4 mb-6">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-indigo-500" required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('user.dashboard') }}" class="text-gray-500 hover:text-gray-800 text-sm font-bold">Kembali</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                        Konfirmasi Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
