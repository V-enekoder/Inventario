<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuppliersController;

Route::get('/', function () {
    return view('welcome');
});
