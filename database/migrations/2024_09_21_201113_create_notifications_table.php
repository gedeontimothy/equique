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
		Schema::create('notifications', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->text('url')->unique()->nullable();
			$table->enum('type', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]);
			$table->json('options')->default('{}');
			$table->enum('view_status', [0, 1, 2, 3])->default(0);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('notifications', function (Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
		Schema::dropIfExists('notifications');
	}
};
