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
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId('payment_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->double('purchase_price')->nullable();
			$table->enum('status', [0, 1, 2, 3, 4])->default(1); // 0:canceled 1:pending 2:success 3:in-progress-of-delivery 4:in-progress-of-refunded
			$table->timestamp('bought_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('orders', function (Blueprint $table) {
			$table->dropForeign('orders_user_id_foreign');
			$table->dropForeign('orders_payment_id_foreign');
		});
		Schema::dropIfExists('orders');
	}
};
