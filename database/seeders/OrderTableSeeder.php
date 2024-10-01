<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;

class OrderTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Order::factory()->count(10)->create(['purchase_price' => null, 'payment_id' => null, 'status' => 1])->map(function($order) {

			$order_products = OrderProduct::factory()->count(random_int(1, 9))->create(['order_id' => $order->id]);

			if(random_int(0, 2) != 1){
	
				$price = 0;
				
				$order_products->map(function($order_product) use (&$price) {

					$price += $order_product->price;

				});

				$p = Payment::factory()->create([
					'purchase_price' => $price,
					'status' => (string) random_int(0, 3),
				]);

				$order->payment_id = $p->id;

				if($p->status != '0')
					$order->purchase_price = $price + $p->tax_price;

				$order->status = $p->status == '0' || $p->status == '1'
					? $p->status
					: ($p->status == '2'
						? '3'
						: '0'
					)
				;
				
				$order_products->map(function($order_product) use ($p, $order) {

					if($p->status == '0'){
						$order_product->quantity_distributed = 0;
						$order_product->save();
					}
					else if($order_product->quantity_distributed > 0 && $p->status == '3' && $order->status != '4')
						$order->status = '4';


				});

				$order->save();

			}

		});

	}

}
