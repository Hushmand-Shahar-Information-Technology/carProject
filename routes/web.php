<?php


use App\Http\Controllers\CarController;
use App\Http\Controllers\routeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('home')->group(function () {
    Route::get('index', [routeController::class, 'home'])->name('home.index');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('car')->group(function () {
    Route::get('index', [CarController::class, 'index'])->name('car.index');
    Route::get('filter', [CarController::class, 'filter'])->name('cars.filter');
    Route::get('register', [CarController::class, 'create'])->name('car.create');
    Route::get('show/{id}', [CarController::class, 'show'])->name('car.show');
    Route::post('store', [CarController::class, 'store'])->name('car.store');
    Route::get('search', [CarController::class, 'search'])->name('cars.search');
    Route::get('feature', [CarController::class, 'feature'])->name('cars.feature');
});

require __DIR__ . '/auth.php';
