<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
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
			'product_id' => fn () => \App\Models\Product::inRandomOrder()->take(1)->first()->id,
			'category_id' => fn () => \App\Models\Category::inRandomOrder()->take(1)->first()->id,
		];
    }
}
