<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\File;

class PersonTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Person::factory()->count(10)->create([
			'file_id' => fn () => File::factory()->create([
				'url' => fn () => 'http://cdn2.net/image/40/' . (random_int(1, 10) == 1
					? fake()->unique()->numberBetween(1, 18) . '?resize&category=face'
					: fake()->unique()->numberBetween(1, 140) . '?resize&category=person'
				),
				'path_file' => null,
			])->id
		]);
	}
}
