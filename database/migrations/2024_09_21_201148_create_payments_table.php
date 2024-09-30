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
		Schema::create('payments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('payment_method_id')->constrained()->cascadeOnUpdate()->nullOnDelete();
			$table->double('purchase_price');
			$table->double('tax_price')->nullable();
			$table->enum('status', [0, 1, 2, 3, 4]);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('product_categories', function (Blueprint $table) {
			$table->dropForeign('product_categories_payment_method_id_foreign');
		});
		Schema::dropIfExists('payments');
	}
};
