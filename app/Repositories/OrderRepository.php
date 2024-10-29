<?php

namespace App\Repositories;

use App\Lib\OptionFilter;
use App\Lib\SortFilter;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class OrderRepository
{

	/**
	 * @var Order
	 */

	protected $order;

	/**
	 * OrderRepository constructor
	 * 
	 * @param Order $order
	 */
	public function __construct(Order $order = null) 
	{
		$this->order = $order ?? new Order;
	}

	/**
	 * Store Order
	 * 
	 * @param array $fields
	 * @return App\Models\Order
	 */
	public function store(array $fields) : Order
	{
		return $this->order->create($fields);
	}

	/**
	 * Update Order
	 * 
	 * @param array $fields
	 * @param $id
	 * @return App\Models\Order
	 */
	public function update(array $fields, $id) : Order
	{
		$order_model_instance = $this->getById($id);
	
		foreach($fields as $property => $value)
			$order_model_instance->$property = $value;
	
		$order_model_instance->save();
	
		return $this->getById($id);
	}

	/**
	 * Delete Order
	 * 
	 * @param $id
	 */
	public function delete($id) 
	{
		$this->getById($id)->delete();
	}

	/**
	 * Get all Order
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll() : Collection
	{
		return $this->order->all();
	}

	/**
	 * Get `Order`
	 * 
	 * @param $id
	 * @return App\Models\Order
	 */
	public function getById($id) : Order
	{
		return $this->order->find($id);
	}

	/**
	 * Get the total number of orders for a user
	 *
	 * @param int $user_id
	 * @param string $status
	 * 
	 * @return int
	 * 
	 */
	public function getTotalOrderByUserId(int $user_id, string|array $status = [])
	{
		$status = is_array($status) ? $status : (is_string($status) ? [$status] : $status);

		$query = Order::where('user_id', $user_id);

		if(is_array($status) && count($status) > 0)
			$query->whereIn('status', $status);
		elseif(is_null($status)) $query->whereNull('status');

		return $query->count();
	}

	/**
	 * Get the total number of paid orders for a user
	 *
	 * @param int $user_id
	 * 
	 * @return [type]
	 * 
	 */
	public function getTotalSuccessfulOrdersByUserId(int $user_id) {
		return $this->getTotalOrderByUserId($user_id, ['2', '3']);
	}

	/**
	 * Get the total number of paid orders for a user
	 *
	 * @param int $user_id
	 * 
	 * @return [type]
	 * 
	 */
	public function getTotalRefundableOrders(int $user_id) {
		return $this->getTotalOrderByUserId($user_id, '4');
	}

	/**
	 * Get a paginate list of orders by userId
	 * 
	 * @param $user_id
	 * @param $request
	 * @return Illuminate\Contracts\Pagination\LengthAwarePaginator|null
	 */
	public function getPaginateWithOptionsByUserId($user_id, Request $request)
	{
		$user = User::find($user_id);

		if($user){

			$query = Order::query();

			$query->where(function($q) use ($user_id) {
				$q->where('user_id', $user_id);
			});

			// $query->orderBy(DB::raw("CASE  WHEN orders.updated_at IS NULL THEN users.updated_at WHEN users.updated_at IS NULL THEN orders.updated_at ELSE CASE  WHEN orders.updated_at > users.updated_at THEN orders.updated_at ELSE users.updated_at END END"), 'desc');

			return $this->getPaginateWithOptions(10, $request, $query);
		}
		return null;
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
		return $this->order->paginate($n, ...$args);
	}

	/**
	 * [Description for getPaginateWithOptions]
	 *
	 * @param int                 $n
	 * @param Request|null        $request
	 * @param Builder|Model|null  $query
	 * @param array               $disable_options
	 * @param mixed               ...$args [$columns = ['*'], $pageName = 'page', $page = null, $total = null]
	 * 
	 * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
	 * 
	 */
	public function getPaginateWithOptions(int $n = 15, Request $request = null, Builder|Model $query = null, $disable_options = [], ...$args) : LengthAwarePaginator
	{

		$request = $request ?? request();

		$options = [
			'date' => [OptionFilter::class .'::date', []],
			'status' => [OptionFilter::class .'::status', []],
			'sort' => [OptionFilter::class .'::sort', []],
		];

		$request_options = $request->all();

		$filtered = false;

		$query = $query ?? Order::query();

		foreach ($options as $option => $callback) {

			if($request->has($option) && array_search($option, $disable_options) === false){

				if(is_callable($callback[0]) && $callback[0]($request->get($option), $query, $request_options, ...(isset($callback[1]) ? $callback[1] : []))){

					$filtered = true;

				}

			}

		}

		// if($filtered)
		// 	dd($query->toSql());

		return ($filtered || $query ? $query->paginate($n, ...$args) : $this->getPaginate($n, ...$args))->appends($request->query());

	}

}
