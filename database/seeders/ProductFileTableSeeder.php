<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFile;

class ProductFileTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		ProductFile::factory()->count(10)->create([
			'file_id' => fn () => \App\Models\File::factory([
				'url' => fn () => 'http://cdn.net/image/40/' . fake()->unique()->numberBetween(1, 147) . '?resize&category=product,electronic',
				// 'url' => fn () => 'http://cdn.net/image/30/' . random_int(1, 1076) . '.jpg',
				'path_file' => null,
			])->create()->id
		]);
	}
}
