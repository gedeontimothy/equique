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
				'url' => fn () => 'http://cdn.net/image/30/' . random_int(0, 1076) . '.jpg',
				'path_file' => null,
			])->create()->id
		]);
	}
}
