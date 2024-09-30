<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class NotificationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'user_id' => fn() => \App\Models\User::inRandomOrder()->take(1)->first()->id,
			'title' => ucfirst($this->faker->words(random_int(1, 4), true)),
			'description' => $this->faker->paragraph(random_int(2,6)),
			'url' => $this->faker->url() . random_int(10000, 99999),
			'type' => random_int(0, 16),
			'view_status' => random_int(0, 3),
		];
	}
}
