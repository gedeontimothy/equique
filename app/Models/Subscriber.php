<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
	use HasFactory;

	/**
	 * Configuration of `updated_at` attribut
	 * 
	 * @var UPDATED_AT
	 */
	const UPDATED_AT = NULL;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"email",
		"code",
		"interaction",
	];

}
