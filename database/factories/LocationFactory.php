<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'name'        => $this->faker->city,
            'latitude'    => $this->faker->latitude,
            'longitude'   => $this->faker->longitude,
            'marker_color'=> '#'.dechex(rand(0x000000, 0xFFFFFF)),
            'description' => $this->faker->sentence,
            'orders'      => rand(1, 10),
        ];
    }
}
