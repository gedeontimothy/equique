<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name' => $this->faker->unique()->sentence(3) . random_int(10000, 99999),
			'original_name' => $this->faker->unique()->sentence(3). random_int(10000, 99999) . "." . $this->faker->fileExtension(),
			'url' => $this->faker->url() . random_int(10000, 99999),
			'path_file' => Str::snake($this->faker->unique()->sentence(3)) . random_int(10000, 99999),
			'size' => $this->faker->randomNumber(9, false),
			'mime_type' => $this->faker->mimeType()
		];
	}
}
