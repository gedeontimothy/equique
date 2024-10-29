<?php

namespace App\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class ProductRepository extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'repository-product';
	}
}