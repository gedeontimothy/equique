<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class OrderProductUpdateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return array (
			'product_id' => 
			array (
				0 => 'exists:App\\Models\\Product,id',
			),
			'order_id' => 
			array (
				0 => 'exists:App\\Models\\Order,id',
			),
			'quantity' => 
			array (
				0 => 'integer',
			),
			'price' => 
			array (
			),
			'quantity_distributed' => 
			array (
				0 => 'integer',
				1 => 'required',
			),
			// 'status' => 
			// array (
			// 	0 => Rule::in(['0', '1', '2', '3', '4']),
			// ),
		);
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return array (
			'product_id.exists' => '`product` doesn\'t exists !',
			'order_id.exists' => '`order` doesn\'t exists !',
			'quantity.integer' => '`quantity` is not Integer',
			'quantity.required' => '`quantity` is required',
		);
	}
}
