<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class SubscriberFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'email' => $this->faker->unique()->safeEmail,
			'code' => uniqid(more_entropy : true),
			'interaction' => ((bool) random_int(0, 5)) ? 0 :  random_int(1, 12),
		];
	}
}
