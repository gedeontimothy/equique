<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\File;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		if(User::count() == 0)
			foreach ([
				[
					'name' => 'Super',
					'firstname' => 'Supery',
					'lastname' => 'Sup',
					'username' => 'super',
					'email' => 'super@mail.com',
					'is' => '0',
				],
				[
					'name' => 'Administrateur',
					'firstname' => 'Admin',
					'lastname' => 'Administrator',
					'username' => 'admin',
					'email' => 'admin@mail.com',
					'is' => '1',
				],
				[
					'name' => 'Agent',
					'firstname' => 'Agenty',
					'lastname' => 'Age',
					'username' => 'agent',
					'email' => 'agent@mail.com',
					'is' => '2',
				],
				[
					'name' => 'User',
					'firstname' => 'Usery',
					'lastname' => 'Use',
					'username' => 'user',
					'email' => 'user@mail.com',
					'is' => null,
				],
			] as $value) {
				User::factory()->create([
					'person_id' => fn () => \App\Models\Person::factory()->create([
						'file_id' => fn () => File::factory()->create([
							'url' => fn () => 'http://cdn2.net/image/40/' . (random_int(1, 10) == 1
								? fake()->unique()->numberBetween(1, 18) . '?resize&category=face'
								: fake()->unique()->numberBetween(1, 140) . '?resize&category=person'
							),
							'path_file' => null,
						])->id,
						'name' => $value['name'],
						'firstname' => $value['firstname'],
						'lastname' => $value['lastname'],
					])->id,
					'username' => $value['username'],
					'email' => $value['email'],
					'is' => $value['is'],
					'email_verified_at' => now(),
				]);
			}
		User::factory()->count(30)->create([
			'person_id' => fn () => \App\Models\Person::factory()->create([
				'file_id' => fn () => File::factory()->create([
					'url' => fn () => 'http://cdn2.net/image/40/' . fake()->unique()->numberBetween(1, 140) . '?resize&category=person',
				])->id
			])->id
		]);
	}
}
