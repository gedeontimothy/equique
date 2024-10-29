<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFileResource extends JsonResource
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
			...(request()->has('file-product-aa') 
				? ['product_id' => $this->product_id, 'file' => new FileResource($this->file)]
				: (request()->has('product-file-aa')
					? ['product' => new ProductResource($this->product), 'file_id' => $this->file_id] 
					: ['product' => new ProductResource($this->product), 'file' => new FileResource($this->file)]
				)
			),
		];
	}
}
