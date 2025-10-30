<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     * Returns all active categories with basic info
     */
    public function index()
    {
        $categories = Category::query()
            ->root()
            ->active()
            ->with(['children' => fn ($q) => $q->active()->ordered()])
            ->ordered()
            ->get();

        return CategoryResource::collection($categories);
    }

    /**
     * GET /api/categories/{slug}
     * Returns a single category with its products
     */
    public function show(string $slug)
    {
        $locale = app()->getLocale();

        $category = Category::query()
            ->where('slug', $slug)
            ->active()
            ->with([
                'parent',
                'children' => fn($q) => $q->active()->ordered(),
                'products' => fn($q) => $q->where('is_active', true)
            ])
            ->first();

        if (! $category) {
            return response()->json([
                'error' => 'NOT_FOUND',
                'message' => __('common.not_found'),
            ], 404);
        }

        // 🧭 Breadcrumb
        $breadcrumb = $category->getAncestors()->reverse()->push($category)->map(function ($cat) use ($locale) {
            return [
                'id' => $cat->id,
                'slug' => $cat->slug,
                'name' => $cat->getTranslation('name', $locale, false),
            ];
        });

        // 🛍️ Продукти
        $products = $category->products()
            ->with(['categories', 'media'])
            ->paginate(12);

        return response()->json([
            'data' => [
                'category' => new \App\Http\Resources\CategoryResource($category),
                'breadcrumb' => $breadcrumb,
                'products' => \App\Http\Resources\ProductResource::collection($products),
                'meta' => [
                    'pagination' => [
                        'total' => $products->total(),
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                    ]
                ]
            ]
        ]);
    }
}
