<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"user_id",
		"payment_id",
		"purchase_price",
		"status",
		"bought_at",
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'bought_at' => 'datetime',
		];
	}

	/**
	 * Get user relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Get payment relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function payment() : BelongsTo
	{
		return $this->belongsTo(Payment::class);
	}

	/**
	 * Get order_products relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function order_products() : HasMany
	{
		return $this->hasMany(OrderProduct::class);
	}

}
