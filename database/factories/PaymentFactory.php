<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class PaymentFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'payment_method_id' => fn() => \App\Models\PaymentMethod::inRandomOrder()->take(1)->first()->id,
			'purchase_price' => $this->faker->randomFloat(2, 0.3, 1299.99),
			'tax_price' => $this->faker->randomFloat(2, 0.01, 1.99),
			'status' => random_int(0, 4), // 0:canceled 1:pending 2:success 3:refunded
		];
	}
}
