<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'file_id' => fn() => File::factory()->create()->id,
			'name' => $this->faker->name,
			'firstname' => $this->faker->firstName,
			'lastname' => random_int(0, 1) == 0 ? $this->faker->lastName : null,
			'phone' => json_encode([$this->faker->e164PhoneNumber, $this->faker->e164PhoneNumber]),
			'sexe' => $this->faker->randomElement(["m", "f"]),
		];
	}
}
