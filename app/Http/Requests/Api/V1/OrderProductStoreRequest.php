<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class OrderProductStoreRequest extends FormRequest
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
				0 => 'required',
				1 => 'exists:App\\Models\\Product,id',
			),
			'order_id' => 
			array (
				0 => 'required',
				1 => 'exists:App\\Models\\Order,id',
			),
			'quantity' => 
			array (
				0 => 'required',
				1 => 'integer',
			),
			'price' => 
			array (
				0 => 'required',
			),
			'quantity_distributed' => 
			array (
				0 => 'integer',
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
			'product_id.required' => '`product` is required',
			'product_id.exists' => '`product` doesn\'t exists !',
			'order_id.required' => '`order` is required',
			'order_id.exists' => '`order` doesn\'t exists !',
			'quantity.required' => '`quantity` is required',
			'quantity.integer' => '`quantity` is not Integer',
			'price.required' => '`price` is required',
		);
	}
}
