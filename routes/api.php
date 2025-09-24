<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BargainController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\AuctionController;
use App\Http\Controllers\API\PromotionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware('api.token')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
    
    // Bargain routes
    Route::apiResource('bargains', BargainController::class);
    Route::post('/bargains/{id}/toggle-status', [BargainController::class, 'toggleStatus']);
    Route::post('/bargains/{id}/update-status', [BargainController::class, 'updateStatus']);
    Route::post('/bargains/{id}/send-warning', [BargainController::class, 'sendWarning']);
    
    // Car routes
    Route::apiResource('cars', CarController::class);
    Route::post('/cars/{id}/toggle-promoted', [CarController::class, 'togglePromoted']);
    Route::get('/cars/{id}/offers', [CarController::class, 'getOffers']);
    
    // Offer routes
    Route::apiResource('offers', OfferController::class);
    
    // Auction routes
    Route::apiResource('auctions', AuctionController::class);
    Route::post('/auctions/{id}/end', [AuctionController::class, 'endAuction']);
    
    // Promotion routes
    Route::apiResource('promotions', PromotionController::class);
    
    // Additional endpoints
    Route::get('/dashboard/stats', [ProfileController::class, 'dashboardStats']);
});