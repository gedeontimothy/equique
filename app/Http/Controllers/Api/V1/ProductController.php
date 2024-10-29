<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Requests\Api\V1\ProductStoreRequest;
use App\Models\Product;
use App\Http\Requests\Api\V1\ProductUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

	/**
	 * ProductController constructor
	 * 
	 * @var App\Repositories\ProductRepository $product_repository
	 */
	protected ProductRepository $product_repository;

	/**
	 * Create a new constructor for this controller.
	 * 
	 * @param ProductRepository $product_repository
	 */
	public function __construct(ProductRepository $product_repository) 
	{
		$this->product_repository = $product_repository;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index() : AnonymousResourceCollection
	{
		return ProductResource::collection(
			$this->product_repository->getPaginate(30)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param ProductStoreRequest $request
	 * @return App\Http\Resources\ProductResource
	 */
	public function store(ProductStoreRequest $request) : ProductResource
	{
		return new ProductResource(
			$this->product_repository->store($request->all())
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param Product $product
	 * @return App\Http\Resources\ProductResource
	 */
	public function show(Product $product) : ProductResource
	{
		return new ProductResource(
			$this->product_repository->getById($product->id)
		);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param ProductUpdateRequest $request
	 * @param Product $product
	 * @return App\Http\Resources\ProductResource
	 */
	public function update(ProductUpdateRequest $request, Product $product) : ProductResource
	{
		return new ProductResource(
			$this->product_repository->update($request->validated(), $product->id)
		);
	}

	/**
	 * Find by `name`
	 * 
	 * @param Request $request
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function findByName(Request $request) : AnonymousResourceCollection
	{
		return ProductResource::collection(
			$this->product_repository->getSearchByName($request->input('product_name'))
		);
	}

	/**
	 * Find by `description`
	 * 
	 * @param Request $request
	 * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function findByDescription(Request $request) : AnonymousResourceCollection
	{
		return ProductResource::collection(
			$this->product_repository->getSearchByDescription($request->input('product_description'))
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param Product $product
	 * @return Illuminate\Http\JsonResponse
	 */
	public function destroy(Product $product) : JsonResponse
	{
		$product->delete();
		return response()->json(null);
	}
}
