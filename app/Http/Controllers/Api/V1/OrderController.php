<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Api\V1\OrderResource;
use App\Http\Requests\Api\V1\OrderStoreRequest;
use App\Models\Order;
use App\Models\User;
use App\Http\Requests\Api\V1\OrderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

	/**
	 * OrderController constructor
	 * 
	 * @var App\Repositories\OrderRepository $order_repository
	 */
	protected OrderRepository $order_repository;

	/**
	 * Create a new constructor for this controller.
	 * 
	 * @param OrderRepository $order_repository
	 */
	public function __construct(OrderRepository $order_repository) 
	{
		$this->order_repository = $order_repository;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index(Request $request) : AnonymousResourceCollection
	{
		return OrderResource::collection(
			$this->order_repository->getPaginateWithOptions(n : 30, request : $request)
		);
		// return OrderResource::collection(
		// 	$this->order_repository->getPaginate(30)
		// );
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param OrderStoreRequest $request
	 * @return App\Http\Resources\OrderResource
	 */
	public function store(OrderStoreRequest $request) : OrderResource
	{
		return new OrderResource(
			$this->order_repository->store($request->all())
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param Order $order
	 * @return App\Http\Resources\OrderResource
	 */
	public function show(Order $order) : OrderResource
	{
		return new OrderResource(
			$this->order_repository->getById($order->id)
		);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param OrderUpdateRequest $request
	 * @param Order $order
	 * @return App\Http\Resources\OrderResource
	 */
	public function update(OrderUpdateRequest $request, Order $order) : OrderResource
	{
		return new OrderResource(
			$this->order_repository->update($request->validated(), $order->id)
		);
	}

	// /**
	//  * Find by `UserId`
	//  * 
	//  * @param Request $request
	//  * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	//  */
	// public function findByUserId(User $user) : AnonymousResourceCollection
	// {
	// 	return OrderResource::collection(
	// 		$this->order_repository->getSearchByName($request->input('product_name'))
	// 	);
	// }

	/**
	 * Find by `UserId`
	 * 
	 * @param Request $request
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection|Illuminate\Http\JsonResponse
	 */
	public function findByUserIdWithOptions($user_id, Request $request) // : AnonymousResourceCollection
	{

		$response = $this->order_repository->getPaginateWithOptionsByUserId($user_id, request : $request);

		return is_null($response)
			? response()->json([
				'data' => [],
				'errors' => [
					'message' => __('validation.exists', ['attribute' => 'user_id']),
				],
			], status : 401) 
			: OrderResource::collection($response)
		;
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param Order $order
	 * @return Illuminate\Http\JsonResponse
	 */
	public function destroy(Order $order) : JsonResponse
	{
		$order->delete();
		return response()->json(null);
	}
	
}
