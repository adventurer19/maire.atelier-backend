<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('position')
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'image',
                'parent_id',
            ]);

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * GET /api/categories/{slug}
     * Returns a single category with its products
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)
                    ->with(['images', 'variants']);
            }])
            ->firstOrFail();

        return response()->json([
            'data' => $category,
        ]);
    }
}
