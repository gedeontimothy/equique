<?php

namespace App\Http\Controllers;

use App\Facades\Repositories\PaymentRepository;
use App\Facades\Repositories\ProductRepository;
use App\Facades\Repositories\UserRepository;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagerController extends Controller
{
	public function dashboard(){
		return Inertia::render('pages/manager/Dashboard', [
			'stats' => [
				'total_users' => User::count(),
				'total_sum_payment' => PaymentRepository::getSumPurchasePrices(),
				'total_product_sold' => ProductRepository::getTotalProductsSold(),
				'total_order' => Order::whereIn('status', ['2', '3'])->count(),
			],
		]);
	}
}
