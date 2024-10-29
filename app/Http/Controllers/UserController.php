<?php

namespace App\Http\Controllers;

use App\Facades\Repositories\UserRepository;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$param_users_type = request()->get('param_users_type');

		$query = User::query()
			->select('users.*', DB::raw('max(orders.updated_at) as orders_updated_at'))
			// ->where('users.id', '<>', request()->user()->id)
			->leftJoin('orders', 'users.id', '=', 'orders.user_id')
			->groupBy('users.id')
			// mysql
				// ->orderBy(DB::raw('GREATEST(orders.updated_at, users.updated_at)'), 'desc')
			->orderBy(DB::raw("CASE  WHEN orders.updated_at IS NULL THEN users.updated_at WHEN users.updated_at IS NULL THEN orders.updated_at ELSE CASE  WHEN orders.updated_at > users.updated_at THEN orders.updated_at ELSE users.updated_at END END"), 'desc')
		;

		if($param_users_type == 3) $query->whereNull('is');
		elseif(!is_null($param_users_type) && array_search($param_users_type, ['1', '2']) !== false)
			$query->where('is', [$param_users_type]);

		$users = UserResource::withStat()::collection($query->paginate(16)->appends(request()->query()));

		return Inertia::render('pages/manager/UserIndex', [
			'users' => $users,
			'segment' => [
				['label' => __('manager.user.base.all'),'value' => 0, ],
				['label' => __('main.administrator.1'),'value' => 1, ],
				['label' => __('main.agent.1'),'value' => 2, ],
				['label' => __('main.simple-user.1'),'value' => 3, ] 
			],
			'param_users_type' => (int) request()->get('param_users_type'),
			// 'get' => ,
		]);
	}
	/**
	 * Display a listing of the resource.
	 */
	public function firstIndex()
	{

		$is = request()->user()->is;

		$datas = UserRepository::getAllFor(request()->get('param_users_type')
			? (request()->get('param_users_type') == 4
				? []
				: (request()->get('param_users_type') == 0
					? ($is == 'super'
						? ['0']
						: []
					)
					: [(string) request()->get('param_users_type')]
				)
			)
			: ($is == 'super' 
				? '*'
				: ($is == 'admin'
					? ['1', '2', '*']
					: null
				)
			)
		, function($query){
			$query
				->where(function($q){
					$q->where('users.id', '<>', request()->user()->id);
				})
				->select('users.*')
				->leftJoin('orders', 'users.id', '=', 'orders.user_id')
				// mysql
					// ->orderBy(DB::raw('GREATEST(orders.updated_at, users.updated_at)'), 'desc')
				->orderBy(DB::raw("CASE  WHEN orders.updated_at IS NULL THEN users.updated_at WHEN users.updated_at IS NULL THEN orders.updated_at ELSE CASE  WHEN orders.updated_at > users.updated_at THEN orders.updated_at ELSE users.updated_at END END"), 'desc')
			;
		}, 55);

		$users = UserResource::withStat()::collection($datas);
		// UserResource::withStat(false);

		return Inertia::render('pages/manager/Users', [
			'users' => $users,
			'segment' => $is == 'agent' ? null : [
				['label' => 'Tous','value' => 0, ],
				...(array_search($is, ['super', 'admin']) !== false 
					? [
						['label' => 'Agent','value' => 2, ],
						['label' => 'Admin','value' => 1, ],
					]
					: []
				),
				...[(array_search($is, ['super', 'admin', 'agent']) !== false 
					? ['label' => 'Utilisateur Simple','value' => 4, ] 
					: []
				)],
			],
			'param_users_type' => (int) request()->get('param_users_type')
		]);

	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$user = User::findOrFail($id);

		UserResource::withStat();

		return Inertia::render('pages/manager/UserShow', [
			'user' => new UserResource($user),
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
