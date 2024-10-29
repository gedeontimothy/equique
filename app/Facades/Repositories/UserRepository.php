<?php

namespace App\Facades\Repositories;

use Illuminate\Support\Facades\Facade;

class UserRepository extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'repository-user';
	}
}