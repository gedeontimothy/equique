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
		Schema::create('product_categories', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('product_categories', function (Blueprint $table) {
			$table->dropForeign('product_categories_product_id_foreign');
			$table->dropForeign('product_categories_category_id_foreign');
		});
		Schema::dropIfExists('product_categories');
	}
};
