<?php

namespace App\Http\Resources\Api\V1;

use App\Facades\Repositories\OrderRepository;
use App\Facades\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	protected static $with_stat = false;
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return array_merge([
			'id' => $this->id,
			'person' => new PersonResource($this->person),
			'username' => $this->username,
			'email' => $this->email,
			'is' => $this->is,
			'created_at' => $this->created_at,
		], static::$with_stat ? [
			'stats' => [
				'total_money_spent' => PaymentRepository::getTotalAmountsOrderedAndTaxedByUserId($this->id),
				'total_orders' => OrderRepository::getTotalOrderByUserId($this->id),
				'total_successful_orders' => OrderRepository::getTotalSuccessfulOrdersByUserId($this->id),
				'total_refundable_orders' => OrderRepository::getTotalRefundableOrders($this->id),
			]
		] : []);
	}

	/**
	 * [Description for withStat]
	 *
	 * @param bool $val
	 * 
	 * @return string
	 * 
	 */
	public static function withStat(bool $val = true) : string {

		static::$with_stat = $val;

		return static::class;

	}
}
