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
		Schema::create('people', function (Blueprint $table) {
			$table->id();
			$table->foreignId('file_id')->unique()->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
			$table->string('name');
			$table->string('firstname');
			$table->string('lastname')->nullable();
			$table->json('phone')->nullable();
			$table->enum('sexe', ["m", "f"])->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('people', function (Blueprint $table) {
			$table->dropForeign('people_file_id_foreign');
		});
		Schema::dropIfExists('people');
	}
};
