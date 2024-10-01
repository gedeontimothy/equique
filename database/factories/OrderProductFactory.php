<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommandProduct>
 */
class OrderProductFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$product = \App\Models\Product::inRandomOrder()->take(1)->first();
		$qt = $this->faker->numberBetween(1, ceil($product->stock / (random_int(0,1) == 1 ? 2 : 1.5)));
		$qt_ds = random_int(0,3) == 2 ? $this->faker->numberBetween(0, $qt) : 0;
		return [
			'order_id' => fn() => \App\Models\Order::inRandomOrder()->take(1)->first()->id,
			'product_id' => fn() => $product->id,
			'price' => $product->price * $qt,
			'quantity' => $qt,
			'quantity_distributed' => $qt_ds,
		];
	}
}
