<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Restaurant;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $restaurants = Restaurant::all();

        foreach ($users as $user) {
            foreach ($restaurants->random(2) as $restaurant) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurant->id,
                ]);
            }
        }
    }
}
