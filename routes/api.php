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
| Base URL: http://maire.atelier.test/api
|--------------------------------------------------------------------------
*/

// ============================================
// PUBLIC ROUTES
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

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/{product:slug}', [ProductController::class, 'show']);
});

// Categories
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{category:slug}', [CategoryController::class, 'show']);
});

// Collections
Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index']);
    Route::get('/{collection:slug}', [CollectionController::class, 'show']);
});

// Search
Route::get('/search', [ProductController::class, 'search']);

// Cart - Public (works for guests with session)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::get('/count', [CartController::class, 'count']);
    Route::post('/items', [CartController::class, 'addItem']);
    Route::put('/items/{item}', [CartController::class, 'updateItem']);
    Route::delete('/items/{item}', [CartController::class, 'removeItem']);
    Route::delete('/', [CartController::class, 'clear']);
    Route::post('/validate', [CartController::class, 'validate']);
});

// ============================================
// AUTHENTICATED ROUTES
// ============================================

Route::middleware('auth:sanctum')->group(function () {

    // Current user profile
    Route::get('/user', function (Request $request) {
        return response()->json([
            'data' => $request->user()->load('addresses'),
        ]);
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
    });

    // Wishlist
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('/', [WishlistController::class, 'add']);
        Route::delete('/{product}', [WishlistController::class, 'remove']);
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle']);
    });

    // Addresses
    Route::apiResource('addresses', AddressController::class);
});

// ============================================
// ADMIN ROUTES
// ============================================

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Dashboard stats
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

    // Export
    Route::get('/orders/export', function () {
        return response()->json(['message' => 'Orders export functionality']);
    });

    Route::get('/products/export', function () {
        return response()->json(['message' => 'Products export functionality']);
    });

    // Bulk operations
    Route::post('/products/bulk-update', function () {
        return response()->json(['message' => 'Products bulk update functionality']);
    });
});

// ============================================
// FALLBACK - 404
// ============================================

Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found',
        'error' => 'ROUTE_NOT_FOUND',
    ], 404);
});
