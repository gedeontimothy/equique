<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\OrderProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Api\V1\OrderProductResource;
use App\Http\Requests\Api\V1\OrderProductStoreRequest;
use App\Models\OrderProduct;
use App\Http\Requests\Api\V1\OrderProductUpdateRequest;
use Illuminate\Http\JsonResponse;

class OrderProductController extends Controller
{

	/**
	 * OrderProductController constructor
	 * 
	 * @var App\Repositories\OrderProductRepository $order_product_repository
	 */
	protected OrderProductRepository $order_product_repository;

	/**
	 * Create a new constructor for this controller.
	 * 
	 * @param OrderProductRepository $order_product_repository
	 */
	public function __construct(OrderProductRepository $order_product_repository) 
	{
		$this->order_product_repository = $order_product_repository;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index() : AnonymousResourceCollection
	{
		return OrderProductResource::collection(
			$this->order_product_repository->getPaginate(30)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param OrderProductStoreRequest $request
	 * @return App\Http\Resources\OrderProductResource
	 */
	public function store(OrderProductStoreRequest $request) : OrderProductResource
	{
		return new OrderProductResource(
			$this->order_product_repository->store($request->all())
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param OrderProduct $order_product
	 * @return App\Http\Resources\OrderProductResource
	 */
	public function show(OrderProduct $order_product) : OrderProductResource
	{
		return new OrderProductResource(
			$this->order_product_repository->getById($order_product->id)
		);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param OrderProductUpdateRequest $request
	 * @param OrderProduct $order_product
	 * @return App\Http\Resources\OrderProductResource
	 */
	public function update(OrderProductUpdateRequest $request, OrderProduct $order_product) : OrderProductResource
	{
		return new OrderProductResource(
			$this->order_product_repository->update($request->validated(), $order_product->id)
		);
	}

	public function findByOrderId($order_id)
	{
		return OrderProductResource::collection(
			$this->order_product_repository->getPaginateByOrderId($order_id, n : 30)
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param OrderProduct $order_product
	 * @return Illuminate\Http\JsonResponse
	 */
	public function destroy(OrderProduct $order_product) : JsonResponse
	{
		$order_product->delete();
		return response()->json(null);
	}


}