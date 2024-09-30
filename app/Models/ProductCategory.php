<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategory extends Model
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
	 * Get category relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category() : BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

}
