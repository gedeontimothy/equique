<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OrderProductController;
use App\Http\Controllers\Api\V1\ProductController;

Route::resource('order-product' , OrderProductController::class);
Route::get('order-products/order/{order_id}' , [OrderProductController::class, 'findByOrderId'])->name('find.order-products.by.order_id');

Route::resource('product' , ProductController::class);

Route::resource('order' , OrderController::class);
Route::get('orders/user/{user_id}' , [OrderController::class, 'findByUserIdWithOptions'])->name('find.orders.by.user.id.with.options');
