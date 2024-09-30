<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class OrderFactory extends Factory
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
			'payment_id' => fn() => \App\Models\Payment::factory()->create()->id,
			'purchase_price' => $this->faker->randomFloat(2, 0.3, 299.99),
			'status' => (string) random_int(0, 4),
			'bought_at' => $this->faker->dateTimeBetween("-9672 hours", "now"),
		];
	}
}
