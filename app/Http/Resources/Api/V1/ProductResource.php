<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
			'name' => $this->name,
			'description' => $this->description,
			'price' => $this->price,
			'stock' => $this->stock,
			...(request()->has('file-product-aa'))
				? ['product_files' => ProductFileResource::collection($this->product_files)]
				: []
			,
			...(request()->has('category-product-aa'))
				? ['product_categories' => ProductFileResource::collection($this->product_categories)]
				: []
			,
			'updated_at' => $this->updated_at,
			'created_at' => $this->created_at,
		];
	}
}
