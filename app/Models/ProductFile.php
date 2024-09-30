<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFile extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"product_id",
		"file_id",
	];

	/**
	 * Get product relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product() : BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	/**
	 * Get file relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function file() : BelongsTo
	{
		return $this->belongsTo(File::class);
	}

}
