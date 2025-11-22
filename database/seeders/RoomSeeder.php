<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'name' => 'Ruang Rapat A - Executive',
                'capacity' => 12,
                'location' => 'Lantai 3 - Gedung Utama',
                'description' => 'Ruang rapat eksekutif dengan fasilitas lengkap dan view kota',
                'image_path' => 'rooms/executive-room.jpg',
                'image_alt' => 'Ruang Rapat Executive dengan meja besar dan kursi leather'
            ],
            [
                'name' => 'Ruang Rapat B - Creative',
                'capacity' => 8,
                'location' => 'Lantai 2 - Gedung Kreatif',
                'description' => 'Ruang dengan whiteboard besar dan suasana kreatif',
                'image_path' => 'rooms/creative-room.jpg',
                'image_alt' => 'Ruang rapat kreatif dengan whiteboard dan sofa'
            ],
            [
                'name' => 'Ruang Rapat C - Conference',
                'capacity' => 20,
                'location' => 'Lantai 1 - Gedung Utama',
                'description' => 'Ruang konferensi besar dengan projector dan sound system',
                'image_path' => 'rooms/conference-room.jpg',
                'image_alt' => 'Ruang konferensi besar dengan kapasitas 20 orang'
            ],
            [
                'name' => 'Ruang Rapat D - Small Team',
                'capacity' => 6,
                'location' => 'Lantai 4 - Gedung Utama',
                'description' => 'Cocok untuk meeting tim kecil dan diskusi intensif',
                'image_path' => 'rooms/small-team-room.jpg',
                'image_alt' => 'Ruang meeting kecil untuk 6 orang'
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}