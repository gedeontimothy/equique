<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"name",
		"description",
		"price",
		"stock",
	];

	/**
	 * Get product_categories relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function product_categories() : HasMany
	{
		return $this->hasMany(ProductCategory::class);
	}

	/**
	 * Get product_files relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function product_files() : HasMany
	{
		return $this->hasMany(ProductFile::class);
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
