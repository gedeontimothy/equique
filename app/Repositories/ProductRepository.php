<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\JoinClause;

class ProductRepository
{

	/**
	 * @var Product
	 */

	protected $product;

	/**
	 * ProductRepository constructor
	 * 
	 * @param Product $product
	 */
	public function __construct(Product $product = null) 
	{
		$this->product = $product ?? new Product;
	}

	/**
	 * Store Product
	 * 
	 * @param array $fields
	 * @return App\Models\Product
	 */
	public function store(array $fields) : Product
	{
		return $this->product->create($fields);
	}

	/**
	 * Update Product
	 * 
	 * @param array $fields
	 * @param $id
	 * @return \App\Models\Product
	 */
	public function update(array $fields, $id) : \App\Models\Product
	{
		$product_model_instance = $this->getById($id);
	
		foreach($fields as $property => $value)
			$product_model_instance->$property = $value;
	
		$product_model_instance->save();
	
		return $this->getById($id);
	}

	/**
	 * Delete Product
	 * 
	 * @param $id
	 */
	public function delete($id) 
	{
		$this->getById($id)->delete();
	}

	/**
	 * Get `Product` by `name`
	 * 
	 * @param string $name
	 */
	public function getSearchByName(string $name) 
	{
		$product = Product::query();
		if(!empty($name)){
			$product->where('name', 'LIKE', '%' . $name . '%');
		}
		return $product->get();
	}

	/**
	 * Get `Product` by `description`
	 * 
	 * @param string $description
	 */
	public function getSearchByDescription(string $description) 
	{
		$product = Product::query();
		if(!empty($description)){
			$product->where('description', 'LIKE', '%' . $description . '%');
		}
		return $product->get();
	}

    /**
	 * Get all Product
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll() : Collection
	{
		return $this->product->all();
	}

	/**
	 * Get `Product`
	 * 
	 * @param $id
	 * @return App\Models\Product
	 */
	public function getById($id) : Product
	{
		return $this->product->find($id);
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
		return $this->product->paginate($n, ...$args);
	}

	/**
	 * Get the total number of products sold
	 *
	 * @return int
	 * 
	 */
	public function getTotalProductsSold()
	{
		return $this->product
			->query()
			->select('products.id')
			->join('order_products', 'products.id', '=', 'order_products.product_id')
			->join('orders', function(JoinClause $join){
				$join->on('order_products.order_id', '=', 'orders.id')->whereIn('orders.status', ['3', '2']);
			})
			->count()
		;
	}


}