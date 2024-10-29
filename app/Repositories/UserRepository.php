<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

	/**
	 * @var User
	 */

	protected $user;

	/**
	 * UserRepository constructor
	 * 
	 * @param User $user
	 */
	public function __construct(User $user = null) 
	{
		$this->user = $user ?? new User;
	}

	/**
	 * Store User
	 * 
	 * @param array $fields
	 * @return App\Models\User
	 */
	public function store(array $fields) : User
	{
		$fields['password'] = Hash::make($fields['password']);
		return $this->user->create($fields);
	}

	/**
	 * Update User
	 * 
	 * @param array $fields
	 * @param $id
	 * @return App\Models\User
	 */
	public function update(array $fields, $id) : User
	{
		$user_model_instance = $this->getById($id);

		if(isset($fields['password']))
			$fields['password'] = Hash::make($fields['password']);
	
		foreach($fields as $property => $value)
			$user_model_instance->$property = $value;
	
		$user_model_instance->save();
	
		return $this->getById($id);
	}

	/**
	 * Delete User
	 * 
	 * @param $id
	 */
	public function delete($id) 
	{
		$this->getById($id)->delete();
	}

	/**
	 * Get `User` by `username`
	 * 
	 * @param string $username
	 */
	public function getSearchByUsername(string $username) 
	{
		$user = User::query();
		if(!empty($username)){
			$user->where('username', 'LIKE', '%' . $username . '%');
		}
		return $user->get();
	}

	/**
	 * Get `User` by `email`
	 * 
	 * @param string $email
	 */
	public function getSearchByEmail(string $email) 
	{
		$user = User::query();
		if(!empty($email)){
			$user->where('email', 'LIKE', '%' . $email . '%');
		}
		return $user->get();
	}

	/**
	 * Get `User` by `password`
	 * 
	 * @param string $password
	 */
	public function getSearchByPassword(string $password) 
	{
		$user = User::query();
		if(!empty($password)){
			$user->where('password', 'LIKE', '%' . $password . '%');
		}
		return $user->get();
	}

	/**
	 * Get all User
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll() : Collection
	{
		return $this->user->all();
	}

	/**
	 * Get `User`
	 * 
	 * @param $id
	 * @return App\Models\User
	 */
	public function getById($id) : User
	{
		return $this->user->find($id);
	}

	/**
	 * Get a paginate list
	 * 
	 * @param int $n
	 * @param mixed ...$args [$columns = ['*'], $pageName = 'page', $page = null, $total = null]
	 * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function getPaginate(int $n = 15, ...$args) : LengthAwarePaginator
	{
		return $this->user->paginate($n, ...$args);
	}

	/**
	 * [Description for getAllFor]
	 *
	 * @param string|array|null $is
	 * @param callable|null $call
	 * @param mixed ...$args [$perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null]
	 * 
	 * @return Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Database\Eloquent\Collection
	 * 
	 */
	public function getAllFor($is, callable $call, ...$args)
	{
		$users = User::query();
		$users->where(function($query) use ($is) {
			if($is == null)
				$query->whereNull('users.is');
			else if($is != '*'){
				$query->whereIn('users.is', is_array($is) ? $is : [$is]);
				if($is == '*' || (is_array($is) && array_search('*', $is) !== false))
					$query->orWhereNull('users.is');
			}
		});
		if($call) $call($users);
		// dd($users->toSQL());
		// dd($users->get()->toArray());
		return !empty($args) ? $users->paginate(...$args) : $users->get();
	}

}