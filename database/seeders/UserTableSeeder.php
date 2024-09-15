<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
		User::factory()->count(30)->create();
	}
}
