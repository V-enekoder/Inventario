<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuppliersController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas relacionadas aos fornecedores
Route::resource('suppliers', SuppliersController::class);

// Si quieres una ruta de inicio
Route::get('/', function () {
    return redirect()->route('suppliers.index');
});

Route::resource('categories', CategoryController::class);
