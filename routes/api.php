<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;



Route::post('/store-product', [ProductController::class, 'store']);
