<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Chirp;
use App\Models\User;

class   ChirpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chirp::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'message' => $this->faker->realText(200),
            'user_id' => User::factory(),
        ];
    }
}
