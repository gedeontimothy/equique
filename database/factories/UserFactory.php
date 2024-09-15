<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Person;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * The current password being used by the factory.
	 */
	protected static ?string $password;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'person_id' => fn () => Person::factory()->create()->id,
			'username' => $this->faker->unique()->userName,
			'email' => $this->faker->unique()->safeEmail,
			'is' => random_int(0,3) == 1 ? $this->faker->randomElement(["1", "2", null]) : null, // 0 : super | 1 : admin | 2 : agent | null : simple user
			'password' => Hash::make('12345678'),
			'email_verified_at' => random_int(1, 20) != 1 ? null : $this->faker->dateTimeBetween('-5 month', 'now'),
			'remember_token' => Str::random(10),
		];
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
