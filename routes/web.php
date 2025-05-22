<?php

use App\Http\Controllers\routeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('home')->group(function () {
    Route::get('index',[routeController::class, 'home'])->name('home.index');
});
