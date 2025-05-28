<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Restaurant;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $restaurants = Restaurant::all();

        foreach ($users as $user) {
            foreach ($restaurants->random(2) as $restaurant) {
                Reservation::factory()->create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurant->id,
                ]);
            }
        }
    }
}