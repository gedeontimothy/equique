<?php

namespace App\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class OrderRepository extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'repository-order';
	}
}