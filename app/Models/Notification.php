<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"user_id",
		"title",
		"description",
		"url",
		"type",
		"options",
		"view_status",
	];

	/**
	 * Get user relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}

}
