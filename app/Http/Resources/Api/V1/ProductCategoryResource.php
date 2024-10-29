<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			...(request()->has('category-product-aa') 
				? ['product_id' => $this->product_id, 'category' => new CategoryResource($this->category)]
				: (request()->has('product-category-aa')
					? ['product' => new ProductResource($this->product), 'category_id' => $this->category_id] 
					: ['product' => new ProductResource($this->product), 'category' => new CategoryResource($this->category)]
				)
			),
		];
	}
}
