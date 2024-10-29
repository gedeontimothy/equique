<?php

namespace App\Providers;

use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class FacadeServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$loader = AliasLoader::getInstance();
		foreach ([
			['abstract' => 'repository-order', 'class' => OrderRepository::class],
			['abstract' => 'repository-payment', 'class' => PaymentRepository::class],
			['abstract' => 'repository-product', 'class' => ProductRepository::class],
			['abstract' => 'repository-user', 'class' => UserRepository::class],
		] as $value) {
			$this->app->singleton($value['abstract'], function ($app) use ($value) {
				return new $value['class']();
			});
		}

		$loader->alias('OrderRepository', \App\Facades\Repositories\OrderRepository::class);
		$loader->alias('PaymentRepository', \App\Facades\Repositories\PaymentRepository::class);
		$loader->alias('ProductRepository', \App\Facades\Repositories\ProductRepository::class);
		$loader->alias('UserRepository', \App\Facades\Repositories\UserRepository::class);
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		//
	}
}
