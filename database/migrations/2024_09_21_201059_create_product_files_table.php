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
		Schema::create('product_files', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignId('file_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('product_files', function (Blueprint $table) {
			$table->dropForeign('product_files_product_id_foreign');
			$table->dropForeign('product_files_file_id_foreign');
		});
		Schema::dropIfExists('product_files');
	}
};
