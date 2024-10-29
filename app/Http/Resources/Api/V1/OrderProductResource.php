<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'product' => new ProductResource($this->product),
			// 'order' => new OrderResource($this->order),
			...(!is_string(request()->get('replace_order')) && !is_string(request()->get('without_order')) 
                ? ['order' => new OrderResource($this->order)] 
                : (is_numeric(request()->get('replace_order')) 
                    ? ['order_id' => (int) request()->get('replace_order')] 
                    : ['order_id' => $this->order_id]
                )
            ),
			'quantity' => $this->quantity,
			'price' => $this->price,
			'quantity_distributed' => $this->quantity_distributed,
			// 'status' => $this->status,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
    }
}
