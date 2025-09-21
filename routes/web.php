<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BargainController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\PromotionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/home/filter-cars', [HomeController::class, 'filter']);
Route::get('/default-cars', [HomeController::class, 'default']);
Route::view('/otp', 'auth.otp');

// Route::prefix('home')->group(function () {
//     Route::get('index', [HomeController::class, 'home'])->name('home.index');
// });

Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
Route::post('/auctions/{id}/end', [AuctionController::class, 'endAuction'])->name('auctions.end');

Route::view('/wizard', 'home.wizard');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/user/profile/bargain/{id}/cars', [ProfileController::class, 'getBargainCars'])->name('user.profile.bargain.cars');
    Route::post('/set-profile-mode', [ProfileController::class, 'setProfileMode'])->name('profile.set-mode');
    // Test routes removed
});

// Language switch route
Route::get('/lang/{locale}', function ($locale, Request $request) {
    if (in_array($locale, ['en', 'ps', 'fa'])) {
        Session::put('locale', $locale);
    }
    return Redirect::back();
})->name('lang.switch');

Route::get('/test-bargain', function () {
    try {
        $bargain = \App\Models\Bargain::with(['promotions', 'cars'])->find(1);
        return response()->json([
            'bargain' => $bargain->toArray(),
            'cars_count' => $bargain->cars->count(),
            'cars' => $bargain->cars->map(function ($car) {
                return [
                    'id' => $car->id,
                    'make' => $car->make,
                    'model' => $car->model,
                    'offers_count' => $car->offers->count()
                ];
            })->toArray()
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
    }
});

Route::get('/test-bargain-cars', function () {
    try {
        $bargain = \App\Models\Bargain::with(['promotions', 'cars'])->find(1);
        return view('test-cars', compact('bargain'));
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
    }
});

Route::get('/test-bargain-show/{id}', function ($id) {
    try {
        $bargain = \App\Models\Bargain::with(['promotions', 'cars'])->findOrFail($id);
        $hasActivePromotion = $bargain->promotions()->where(function ($q) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })->exists();

        $activePromotion = $bargain->promotions()
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->latest('ends_at')
            ->first();

        $activePromotionEndsAt = $activePromotion?->ends_at;

        return view('bargains.show', compact('bargain', 'hasActivePromotion', 'activePromotionEndsAt'));
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
    }
});

Route::prefix('bargains')->group(function () {
    Route::get('/', [BargainController::class, 'index'])->name('bargains.index');
    Route::get('/data', [BargainController::class, 'getData'])->name('bargains.data');
    Route::get('/create', [BargainController::class, 'create'])->name('bargains.create')->middleware('prevent.bargain.registration');
    Route::post('/store', [BargainController::class, 'store'])->name('bargains.store');
    Route::get('/edit/{id}', [BargainController::class, 'edit'])->name('bargains.edit');
    Route::put('/update/{id}', [BargainController::class, 'update'])->name('bargains.update');
    Route::delete('/delete/{id}', [BargainController::class, 'destroy'])->name('bargains.destroy');
    Route::post('/toggle-status/{id}', [BargainController::class, 'toggleStatus'])->name('bargains.toggle-status');
    Route::get('/show/{id}', [BargainController::class, 'show'])->name('bargains.show');

    // Status management routes
    Route::post('/update-status/{id}', [BargainController::class, 'updateStatus'])->name('bargains.update-status');
    Route::post('/send-warning/{id}', [BargainController::class, 'sendWarning'])->name('bargains.send-warning');
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
    Route::get('show/{id}/offers', [CarController::class, 'getOffers'])->name('car.show.offers');
    Route::post('store', [CarController::class, 'store'])->name('car.store');
    Route::get('search', [CarController::class, 'search'])->name('cars.search');
    Route::get('feature', [CarController::class, 'feature'])->name('cars.feature');
    Route::get('directory', [CarController::class, 'CarDirectory'])->name('car.directory');
    Route::get('compare', [CarController::class, 'compare'])->name('car.compare');
    Route::post('carts', [CarController::class, 'cart'])->name('carts.show');
    Route::post('offer', [OfferController::class, 'store'])->name('car.offer');
    Route::post('toggle-promoted/{id}', [CarController::class, 'togglePromoted'])->name('car.toggle-promoted');
});

Route::prefix('promotions')->group(function () {
    Route::get('/', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/list', [PromotionController::class, 'list'])->name('promotions.list');
    Route::post('/promote', [PromotionController::class, 'promote'])->name('promotions.promote');
    Route::post('/unpromote', [PromotionController::class, 'unpromote'])->name('promotions.unpromote');
});

// Notification routes
Route::post('mark-notification-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.markAsRead');

Route::get('/chat/send-product/{user_id}/{car_id}', [App\Http\Controllers\ChatController::class, 'sendProductMessage'])->name('send.product.message');

// API route for car comparison
Route::get('/api/cars/details', [CarController::class, 'getCarDetails'])->name('api.cars.details');

// Test route for auction filtering
Route::get('/test-auction-filter', function () {
    $cars = App\Models\Car::query()
        // Show ONLY cars that have active auctions
        ->whereHas('auctions', function ($subQuery) {
            $subQuery->where('status', 'active');
        })
        ->with(['auctions' => function ($q) {
            $q->where('status', 'active')->latest();
        }])
        ->get();

    return response()->json([
        'count' => $cars->count(),
        'cars' => $cars->toArray()
    ]);
});

require __DIR__ . '/auth.php';
