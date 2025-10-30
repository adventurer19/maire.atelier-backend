<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List all active products with optional category filter and pagination.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);
        $categoryId = $request->query('category_id');

        $query = Product::query()
            ->with(['categories', 'variants.attributeOptions', 'media'])
            ->where('is_active', true)
            ->orderByDesc('created_at');

        if ($categoryId) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        }

        $products = $query->paginate($perPage);

        return ProductResource::collection($products);
    }

    /**
     * GET /api/products/featured
     * Retrieve featured products (non-paginated).
     */
    public function featured(Request $request)
    {
        $limit = (int) $request->query('limit', 8);

        $products = Product::query()
            ->with(['categories', 'media'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'count' => $products->count(),
            ],
        ]);
    }

    /**
     * GET /api/products/{slug}
     * Retrieve a single product by slug.
     */
    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['categories', 'variants.attributeOptions', 'media', 'reviews'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        abort_if(!$product, 404, __('Product not found.'));

        return new ProductResource($product);
    }

    /**
     * GET /api/search?q=dress
     * Search products by keyword with pagination.
     */
    public function search(Request $request)
    {
        $queryString = trim($request->input('q', ''));

        $perPage = (int) $request->input('per_page', 12);

        if ($queryString === '') {
            return $this->error('VALIDATION_ERROR', __('validation.failed'), [
                'q' => ['Search query is required.'],
            ], 422);
        }

        $products = Product::query()
            ->with(['categories', 'media'])
            ->where('is_active', true)
            ->where(function ($q) use ($queryString) {
                $q->where('name->bg', 'LIKE', "%{$queryString}%")
                    ->orWhere('name->en', 'LIKE', "%{$queryString}%")
                    ->orWhere('description->bg', 'LIKE', "%{$queryString}%")
                    ->orWhere('description->en', 'LIKE', "%{$queryString}%")
                    ->orWhere('sku', 'LIKE', "%{$queryString}%");
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'pagination' => [
                    'total' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ],
                'query' => $queryString
            ]
        ]);
    }

}
