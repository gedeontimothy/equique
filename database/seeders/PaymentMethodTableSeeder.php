<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// PaymentMethod::factory()->count(10)->create();
		foreach([
			'stripe',
			'paypal',
			'google-pay',
			'apple-pay',
		] as $datas){
			PaymentMethod::firstOrCreate(['name' => $datas]);
		}
	}
}
