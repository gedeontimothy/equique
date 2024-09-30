<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"name",
	];

	/**
	 * Get payments relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function payments() : HasMany
	{
		return $this->hasMany(Payment::class);
	}

}
