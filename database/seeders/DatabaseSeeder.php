<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\ProductCategory;
use App\Models\ProductFile;
use App\Models\Subscriber;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// User::factory(10)->create();

		// User::factory()->create([
		// 	'name' => 'Test User',
		// 	'email' => 'test@example.com',
		// ]);

		$this->call([
			// FileTableSeeder::class,
			// PersonTableSeeder::class,
			UserTableSeeder::class,
			CategoryTableSeeder::class,
			SubscriberTableSeeder::class,
			ProductTableSeeder::class,
			PaymentMethodTableSeeder::class,
			ProductFileTableSeeder::class,
			NotificationTableSeeder::class,
			ProductCategoryTableSeeder::class,
			// PaymentTableSeeder::class,
			OrderTableSeeder::class,
			// OrderProductTableSeeder::class,
		]);
	}
}
