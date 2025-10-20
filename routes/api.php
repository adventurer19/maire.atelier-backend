<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\AddressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| Базов URL: http://maire.atelier.test/api
|
*/

// ============================================
// PUBLIC ROUTES (Без authentication)
// ============================================

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'locale' => app()->getLocale(),
        'version' => '1.0.0',
    ]);
});

// Products - публични
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/{product:slug}', [ProductController::class, 'show']);
});

// Categories - публични
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{category:slug}', [CategoryController::class, 'show']);
});

// Collections - публични
Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index']);
    Route::get('/{collection:slug}', [CollectionController::class, 'show']);
});

// Search - публичен
Route::get('/search', [ProductController::class, 'search']);

// ============================================
// AUTHENTICATED ROUTES (Sanctum required)
// ============================================

Route::middleware('auth:sanctum')->group(function () {

    // Current user profile
    Route::get('/user', function (Request $request) {
        return response()->json([
            'data' => $request->user()->load('addresses'),
        ]);
    });

    // Orders - само собствените поръчки
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
    });

    // Cart - кошница
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/items', [CartController::class, 'addItem']);
        Route::put('/items/{item}', [CartController::class, 'updateItem']);
        Route::delete('/items/{item}', [CartController::class, 'removeItem']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // Wishlist - любими продукти
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('/', [WishlistController::class, 'add']);
        Route::delete('/{product}', [WishlistController::class, 'remove']);
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle']);
    });

    // Addresses - адреси за доставка
    Route::apiResource('addresses', AddressController::class);
});

// ============================================
// ADMIN ROUTES (за админски операции)
// ============================================

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Dashboard статистики
    Route::get('/dashboard/stats', function () {
        return response()->json([
            'message' => 'Admin Dashboard Stats',
            'data' => [
                'total_orders' => \App\Models\Order::count(),
                'total_products' => \App\Models\Product::count(),
                'total_users' => \App\Models\User::count(),
            ],
        ]);
    });

    // Export данни (placeholder)
    Route::get('/orders/export', function () {
        return response()->json(['message' => 'Orders export functionality']);
    });

    Route::get('/products/export', function () {
        return response()->json(['message' => 'Products export functionality']);
    });

    // Bulk операции (placeholder)
    Route::post('/products/bulk-update', function () {
        return response()->json(['message' => 'Products bulk update functionality']);
    });
});

// ============================================
// FALLBACK ROUTE (404 for API)
// ============================================

Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found',
        'error' => 'ROUTE_NOT_FOUND',
    ], 404);
});
