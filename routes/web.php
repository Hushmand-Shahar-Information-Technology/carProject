<?php


use App\Http\Controllers\CarController;
use App\Http\Controllers\routeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home.index');
Route::post('/home/filter-cars', [routeController::class, 'filter']);
Route::get('/default-cars', [routeController::class, 'default']);
Route::view('/otp', 'auth.otp');

// Route::prefix('home')->group(function () {
//     Route::get('index', [routeController::class, 'home'])->name('home.index');
// });

Route::view('/wizard', 'home.wizard');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile');
});

Route::prefix('car')->group(function () {
    Route::get('index', [CarController::class, 'index'])->name('car.index');
    Route::get('filter', [CarController::class, 'filter'])->name('cars.filter');
    Route::get('register', [CarController::class, 'create'])->name('car.create');
    Route::get('show/{id}', [CarController::class, 'show'])->name('car.show');
    Route::post('store', [CarController::class, 'store'])->name('car.store');
    Route::get('search', [CarController::class, 'search'])->name('cars.search');
    Route::get('feature', [CarController::class, 'feature'])->name('cars.feature');
    Route::get('directory', [CarController::class, 'CarDirectory'])->name('car.directory');

    Route::get('compare', [CarController::class, 'compare'])->name('car.compare');
    Route::get('directory', [CarController::class, 'CarDirectory'])->name('car.directory');
    Route::post('carts', [CarController::class, 'cart'])->name('carts.show');
    Route::post('offer', [OfferController::class, 'store'])->name('offer.store');
});



Route::get('/chat/send-product/{user_id}/{car_id}', [App\Http\Controllers\ChatController::class, 'sendProductMessage'])->name('send.product.message');

require __DIR__ . '/auth.php';
