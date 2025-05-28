<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'overview' => $this->faker->realText(100),
            'image' => $this->faker->imageUrl(640, 480, 'food', true),
        ];
    }
}
