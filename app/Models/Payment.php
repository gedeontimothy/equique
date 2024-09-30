<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"payment_method_id",
		"purchase_price",
		"tax_price",
		"status",
	];

	/**
	 * Get payment_method relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function payment_method() : BelongsTo
	{
		return $this->belongsTo(PaymentMethod::class);
	}

	/**
	 * Get order relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function order() : HasOne
	{
		return $this->hasOne(Order::class);
	}

}
