<?php

namespace App\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class PaymentRepository extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'repository-payment';
	}
}