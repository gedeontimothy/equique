<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('order_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->double('price');
			$table->integer('quantity');
			$table->integer('quantity_distributed')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('order_products', function (Blueprint $table) {
			$table->dropForeign('order_products_order_id_foreign');
			$table->dropForeign('order_products_product_id_foreign');
		});
		Schema::dropIfExists('order_products');
	}
};
