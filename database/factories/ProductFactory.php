<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
	use HasFactory;
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->unique()->word,
			'description' => $this->faker->paragraph(random_int(2,6)),
			'stock' => $this->faker->numberBetween(0, 350),
			'price' => $this->faker->randomFloat(2, 0.12, 899.99)
		];
	}
}
