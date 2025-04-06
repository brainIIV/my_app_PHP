<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/category', [CategoryController::class, 'store']);
Route::delete('/category={category}', [CategoryController::class, 'destroy']);

Route::post('/product', [ProductController::class, 'store']);
Route::patch('/product={product}', [ProductController::class, 'update']);
Route::delete('/product={product}', [ProductController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category={category}', [ProductController::class, 'showInCategory']);
Route::get('/products/price=min{min}_max{max}', [ProductController::class, 'showInPriceRange']);
Route::get('/products/not_deleted', [ProductController::class, 'showNotDeleted']);
Route::get('/products/by_name={name}', [ProductController::class, 'showByName']);
Route::get('/products/by_name_category={name}', [ProductController::class, 'showByNameCategory']);
Route::get('/products/published={mark}', [ProductController::class, 'showPublished']);
