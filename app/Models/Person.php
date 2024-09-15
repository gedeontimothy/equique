<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"file_id",
		"name",
		"firstname",
		"lastname",
		"phone",
		"sexe",
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $casts = [
		'phone' => 'json'
	];

	/**
	 * Get the file that owns the person
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function file() : BelongsTo
	{
		return $this->belongsTo(File::class);
	}

	/**
	 * Get user relationship
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() : HasOne
	{
		return $this->hasOne(User::class);
	}

}
