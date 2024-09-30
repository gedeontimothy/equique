<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"order_id",
		"product_id",
	];

	/**
	 * Get order relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function order() : BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Get product relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product() : BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

}
