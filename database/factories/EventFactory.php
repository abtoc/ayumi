<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => "イベント_".fake()->dateTime()->format('YmdHis'),
            'mixch_id' => fake()->randomNumber(),
            'start_on' => fake()->date(),
            'end_on' => fake()->date(),
            'description' => fake()->realText(),
        ];
    }
}
