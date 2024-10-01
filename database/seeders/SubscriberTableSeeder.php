<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscriber;

class SubscriberTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{	

		if(Subscriber::count() == 0)
			Subscriber::factory()->create(['email' => 'gedeonbateko3@gmail.com']);

		Subscriber::factory()->count(3)->create();

	}
}
