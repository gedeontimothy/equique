<?php

namespace App\Repositories;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class OrderProductRepository
{

	/**
	 * @var OrderProduct
	 */

	protected $order_product;

	/**
	 * OrderProductRepository constructor
	 * 
	 * @param OrderProduct $order_product
	 */
	public function __construct(OrderProduct $order_product = null) 
	{
		$this->order_product = $order_product ?? new OrderProduct;
	}

	/**
	 * Store OrderProduct
	 * 
	 * @param array $fields
	 * @return App\Models\OrderProduct
	 */
	public function store(array $fields) : OrderProduct
	{
		return $this->order_product->create($fields);
	}

	/**
	 * Update OrderProduct
	 * 
	 * @param array $fields
	 * @param $id
	 * @return App\Models\OrderProduct
	 */
	public function update(array $fields, $id) //: OrderProduct
	{
		$order_product_model_instances = $this->getById($id);
	
		foreach($fields as $property => $value)
			$order_product_model_instances->$property = $value;
	
		$order_product_model_instances->save();
	
		return $this->getById($id);
	}

	/**
	 * Delete OrderProduct
	 * 
	 * @param $id
	 */
	public function delete($id) 
	{
		$this->getById($id)->delete();
	}

	/**
	 * Get all OrderProduct
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll() : Collection
	{
		return $this->order_product->all();
	}

	/**
	 * Get `OrderProduct`
	 * 
	 * @param $id
	 * @return App\Models\OrderProduct
	 */
	public function getById($id) : OrderProduct
	{
		return $this->order_product->find($id);
	}

	public function getTotalByProductId(int $product_id) : int
	{
		return $this->order_product->where('product_id', $product_id)->count();
	}

	public function getTotalByOrderId(int $order_id) : int
	{
		return $this->order_product->where('order_id', $order_id)->count();
	}

	/**
	 * Get a paginate list of order products by orderId
	 *
	 * @param mixed $order_id
	 * @param int $n
	 * @param mixed ...$args
	 * 
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 * 
	 */
	public function getPaginateByOrderId($order_id, int $n = 15, ...$args) : LengthAwarePaginator
	{
		return $this
			->order_product
			->where('order_id', $order_id)
			->paginate($n, ...$args)
		;
	}


	/**
	 * Get a paginate list
	 * 
	 * @param int $n
	 * @param mixed ...$args [$columns = ['*'], $pageName = 'page', $page = null, $total = null]
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function getPaginate(int $n = 15, ...$args) : LengthAwarePaginator
	{
		return $this->order_product->paginate($n, ...$args);
	}

}