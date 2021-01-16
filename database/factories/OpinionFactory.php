<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Opinion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpinionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Opinion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'parent_id' => null,
            'opinion' => $this->faker->realText(280),
        ];
    }
}
