<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List all active products with optional filters: category, price range, stock status, and sorting.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);
        
        // Category filter - support both category_id and category (slug)
        $categoryId = $request->query('category_id');
        $categorySlug = $request->query('category');
        
        // Price filters
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');
        
        // Stock filter
        $inStock = $request->query('in_stock');
        
        // Sort option
        $sort = $request->query('sort', 'newest');

        $query = Product::query()
            ->with(['categories', 'variants.attributeOptions', 'media'])
            ->where('is_active', true);

        // Category filter
        if ($categoryId) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        } elseif ($categorySlug) {
            // Find category by slug and filter products
            $category = Category::where('slug', $categorySlug)->where('is_active', true)->first();
            if ($category) {
                $query->whereHas('categories', fn($q) => $q->where('categories.id', $category->id));
            }
        }

        // Price filters
        if ($priceMin !== null && $priceMin !== '') {
            $priceMinValue = filter_var($priceMin, FILTER_VALIDATE_FLOAT);
            if ($priceMinValue !== false && $priceMinValue >= 0) {
                $query->where('price', '>=', $priceMinValue);
            }
        }
        
        if ($priceMax !== null && $priceMax !== '') {
            $priceMaxValue = filter_var($priceMax, FILTER_VALIDATE_FLOAT);
            if ($priceMaxValue !== false && $priceMaxValue >= 0) {
                $query->where('price', '<=', $priceMaxValue);
            }
        }

        // Stock filter
        if ($inStock) {
            $query->inStock();
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderByRaw("JSON_EXTRACT(name, '$.{$this->getLocaleKey()}') ASC");
                break;
            case 'name_desc':
                $query->orderByRaw("JSON_EXTRACT(name, '$.{$this->getLocaleKey()}') DESC");
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate($perPage);

        return ProductResource::collection($products);
    }

    /**
     * Get the current locale key for JSON extraction
     */
    private function getLocaleKey(): string
    {
        $locale = app()->getLocale();
        return $locale === 'bg' ? 'bg' : 'en';
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
