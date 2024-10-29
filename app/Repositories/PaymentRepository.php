<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class PaymentRepository
{

	/**
	 * @var Payment
	 */

	protected $payment;

	/**
	 * PaymentRepository constructor
	 * 
	 * @param Payment $payment
	 */
	public function __construct(Payment $payment = null) 
	{
		$this->payment = $payment ?? new Payment;
	}

	/**
	 * Store Payment
	 * 
	 * @param array $fields
	 * @return App\Models\Payment
	 */
	public function store(array $fields) : Payment
	{
		return $this->payment->create($fields);
	}

	/**
	 * Update Payment
	 * 
	 * @param array $fields
	 * @param $id
	 * @return App\Models\Payment
	 */
	public function update(array $fields, $id) : Payment
	{
		$payment_model_instance = $this->getById($id);
	
		foreach($fields as $property => $value)
			$payment_model_instance->$property = $value;
	
		$payment_model_instance->save();
	
		return $this->getById($id);
	}

	/**
	 * Delete Payment
	 * 
	 * @param $id
	 */
	public function delete($id) 
	{
		$this->getById($id)->delete();
	}

	/**
	 * Get `Payment` by `paymentable_type`
	 * 
	 * @param string $paymentable_type
	 */
	public function getSearchByPaymentableType(string $paymentable_type) 
	{
		$payment = Payment::query();
		if(!empty($paymentable_type)){
			$payment->where('paymentable_type', 'LIKE', '%' . $paymentable_type . '%');
		}
		return $payment->get();
	}

	/**
	 * Get `Payment` by `payment_key`
	 * 
	 * @param string $payment_key
	 */
	public function getSearchByPaymentKey(string $payment_key) 
	{
		$payment = Payment::query();
		if(!empty($payment_key)){
			$payment->where('payment_key', 'LIKE', '%' . $payment_key . '%');
		}
		return $payment->get();
	}

	/**
	 * Get all Payment
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll() : Collection
	{
		return $this->payment->all();
	}

	/**
	 * Get `Payment`
	 * 
	 * @param $id
	 * @return App\Models\Payment
	 */
	public function getById($id) : Payment
	{
		return $this->payment->find($id);
	}

	/**
	 * Get a user's total order amount and tax amount
	 *
	 * @param mixed $user_id
	 * 
	 * @return array
	 * 
	 */
	public function getTotalAmountsOrderedAndTaxedByUserId($user_id) : array{
		return Payment::query()
			->select(DB::raw(trim('
				SUM("payments"."purchase_price") as total_purchase_price, 
				SUM("payments"."tax_price") as total_tax_price
			')))
			->join('orders', 'payments.id', '=', 'orders.payment_id')
			->join('users', function(JoinClause $join) use ($user_id){
				$join
					->on('orders.user_id', '=', 'users.id')
					->where('users.id', $user_id)
				;
			})
			->whereIn('orders.status', ['2', '3', '4'])
			->get()->first()
			->toArray()
		;
	}

	/**
	 * Get a paginate list
	 * 
	 * @param int $n
	 * @param mixed ...$args [$columns = ['*'], $pageName = 'page', $page = null, $total = null]
	 * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function getPaginate(int $n = 15, ...$args) : LengthAwarePaginator
	{
		return $this->payment->paginate($n, ...$args);
	}

	/**
	 * Get the total sum of purchase prices paid
	 *
	 * @return null|int
	 * 
	 */
	public static function getSumPurchasePrices(){
		return DB::table('payments')
			->select(DB::raw('SUM(purchase_price) as total'))
			->where('status', '2')
			->whereNull('payments.deleted_at')
			->first()
			->total
		;
	}

}