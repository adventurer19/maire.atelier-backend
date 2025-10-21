<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\AuthController;
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
| Sanctum is used for auth (Bearer Token)
|--------------------------------------------------------------------------
*/

// ============================================
// PUBLIC ROUTES
// ============================================

// 🩺 Health check
Route::get('/health', fn() => response()->json([
    'status' => 'ok',
    'timestamp' => now()->toIso8601String(),
    'locale' => app()->getLocale(),
    'version' => '1.0.0',
]));

// 🛍️ Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/{product:slug}', [ProductController::class, 'show']);
});

// 🗂️ Categories
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{category:slug}', [CategoryController::class, 'show']);
});

// 🎯 Collections
Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index']);
    Route::get('/{collection:slug}', [CollectionController::class, 'show']);
});

// 🔍 Search
Route::get('/search', [ProductController::class, 'search']);

// 🛒 Cart (guest or authenticated)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::get('/count', [CartController::class, 'count']);
    Route::post('/items', [CartController::class, 'addItem']);
    Route::put('/items/{item}', [CartController::class, 'updateItem']);
    Route::delete('/items/{item}', [CartController::class, 'removeItem']);
    Route::delete('/', [CartController::class, 'clear']);
    Route::post('/validate', [CartController::class, 'validateCart']);
});

// ============================================
// AUTH ROUTES (Sanctum Bearer Token)
// ============================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // 👤 Current user
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // 📦 Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::post('/', [OrderController::class, 'store']);
        Route::post('/{order}/cancel', [OrderController::class, 'cancel']); // добавено от OrderService
    });

    // ❤️ Wishlist
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('/', [WishlistController::class, 'add']);
        Route::delete('/{product}', [WishlistController::class, 'remove']);
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle']);
    });

    // 🏠 Addresses
    Route::apiResource('addresses', AddressController::class);
});

// ============================================
// ADMIN ROUTES (Protected by 'admin' middleware)
// ============================================

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard/stats', fn() => response()->json([
        'message' => 'Admin Dashboard Stats',
        'data' => [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
        ],
    ]));

    // Exports
    Route::get('/orders/export', fn() => response()->json(['message' => 'Orders export endpoint']));
    Route::get('/products/export', fn() => response()->json(['message' => 'Products export endpoint']));

    // Bulk actions
    Route::post('/products/bulk-update', fn() => response()->json(['message' => 'Products bulk update endpoint']));
});

// ============================================
// FALLBACK - 404
// ============================================

Route::fallback(fn() => response()->json([
    'error' => 'ROUTE_NOT_FOUND',
    'message' => 'The requested endpoint does not exist.',
], 404));
