<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Demo accounts (password for both: "password")
        $admin = User::firstOrNew(['email' => 'admin@hotel.test']);
        $admin->name = 'Hotel Admin';
        $admin->password = Hash::make('password');
        $admin->is_admin = true; // remove this line if you use a different role system
        $admin->save();

        $guest = User::firstOrNew(['email' => 'guest@hotel.test']);
        $guest->name = 'Demo Guest';
        $guest->password = Hash::make('password');
        $guest->save();

        // Rooms (photos come from picsum.photos so they work offline-free of uploads)
        $rooms = [
            ['Standard Single',     'single', 6500,  1, 'A cosy single room with a work desk, fast Wi-Fi and a private bathroom. Ideal for solo business travellers.'],
            ['Standard Double',     'double', 9000,  2, 'Comfortable double room with a queen bed, flat-screen TV and city views.'],
            ['Deluxe Double',       'double', 12500, 2, 'Spacious deluxe room with a king bed, a sitting area and a complimentary breakfast.'],
            ['Twin Room',           'double', 9500,  2, 'Two single beds, perfect for friends or colleagues travelling together.'],
            ['Family Room',         'family', 16000, 4, 'Large room with a king bed and two single beds, plus a small play area for kids.'],
            ['Junior Suite',        'suite',  19500, 3, 'Suite with a separate living area, a mini-bar and a balcony.'],
            ['Executive Suite',     'suite',  26000, 3, 'Top-floor suite with a lounge, work area, bathtub and panoramic views.'],
            ['Presidential Suite',  'suite',  45000, 4, 'Our finest suite: two bedrooms, a private dining area and butler service.'],
        ];

        foreach ($rooms as $i => [$name, $type, $price, $capacity, $description]) {
            Room::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'type' => $type,
                    'price_per_night' => $price,
                    'capacity' => $capacity,
                    'description' => $description,
                    'image' => 'https://picsum.photos/seed/hotel-room-' . ($i + 1) . '/800/500',
                    'is_available' => true,
                ]
            );
        }
    }
}
