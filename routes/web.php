<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BargainController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/', 'home.index')->name('home.index');
Route::post('/home/filter-cars', [HomeController::class, 'filter']);
Route::get('/default-cars', [HomeController::class, 'default']);
Route::view('/otp', 'auth.otp');

// Route::prefix('home')->group(function () {
//     Route::get('index', [HomeController::class, 'home'])->name('home.index');
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

// Language switch route
Route::get('/lang/{locale}', function ($locale, Request $request) {
    if (in_array($locale, ['en', 'ps', 'fa'])) {
        Session::put('locale', $locale);
    }
    return Redirect::back();
})->name('lang.switch');



Route::prefix('bargains')->group(function () {
    Route::get('/', [BargainController::class, 'index'])->name('bargains.index');
    Route::get('/data', [BargainController::class, 'getData'])->name('bargains.data');
    Route::get('/create', [BargainController::class, 'create'])->name('bargains.create');
    Route::post('/store', [BargainController::class, 'store'])->name('bargains.store');
    Route::get('/edit/{id}', [BargainController::class, 'edit'])->name('bargains.edit');
    Route::put('/update/{id}', [BargainController::class, 'update'])->name('bargains.update');
    Route::delete('/delete/{id}', [BargainController::class, 'destroy'])->name('bargains.destroy');
    Route::post('/toggle-status/{id}', [BargainController::class, 'toggleStatus'])->name('bargains.toggle-status');
    Route::get('/show/{id}', [BargainController::class, 'show'])->name('bargains.show');
});


Route::prefix('car')->group(function () {
    Route::get('index', [CarController::class, 'index'])->name('car.index');
    Route::get('filter', [CarController::class, 'filter'])->name('cars.filter');
    Route::get('rent', [CarController::class, 'rentIndex'])->name('car.rent');
    Route::get('filter-rent', [CarController::class, 'filterRent'])->name('cars.filter-rent');
    Route::get('auction', [CarController::class, 'auction'])->name('car.auction');
    Route::get('filter-auction', [CarController::class, 'filterAuction'])->name('cars.filter-auction');
    Route::get('register', [CarController::class, 'create'])->name('car.create');
    Route::get('show/{id}', [CarController::class, 'show'])->name('car.show');
    Route::post('store', [CarController::class, 'store'])->name('car.store');
    Route::get('search', [CarController::class, 'search'])->name('cars.search');
    Route::get('feature', [CarController::class, 'feature'])->name('cars.feature');
    Route::get('directory', [CarController::class, 'CarDirectory'])->name('car.directory');
    Route::get('compare', [CarController::class, 'compare'])->name('car.compare');
    Route::post('carts', [CarController::class, 'cart'])->name('carts.show');
    Route::post('offer', [OfferController::class, 'store'])->name('offer.store');
    Route::post('toggle-promoted/{id}', [CarController::class, 'togglePromoted'])->name('car.toggle-promoted');
});

Route::prefix('promotions')->group(function () {
    Route::get('/', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/list', [PromotionController::class, 'list'])->name('promotions.list');
    Route::post('/promote', [PromotionController::class, 'promote'])->name('promotions.promote');
    Route::post('/unpromote', [PromotionController::class, 'unpromote'])->name('promotions.unpromote');
});




Route::get('/chat/send-product/{user_id}/{car_id}', [App\Http\Controllers\ChatController::class, 'sendProductMessage'])->name('send.product.message');

// API route for car comparison
Route::get('/api/cars/details', [CarController::class, 'getCarDetails'])->name('api.cars.details');

require __DIR__ . '/auth.php';
