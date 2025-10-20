<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * Get all active products with pagination
     */
    public function getActivePaginated(int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['categories', 'variants.attributeOptions', 'media'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get featured products
     */
    public function getFeatured(int $limit = 8): Collection
    {
        return Product::query()
            ->with(['categories', 'media'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Find product by slug
     */
    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with(['categories', 'variants.attributeOptions', 'media', 'reviews'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    /**
     * Search products by query
     */
    public function search(string $query, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['categories', 'media'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name->bg', 'LIKE', "%{$query}%")
                    ->orWhere('name->en', 'LIKE', "%{$query}%")
                    ->orWhere('description->bg', 'LIKE', "%{$query}%")
                    ->orWhere('description->en', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Filter products by category
     */
    public function filterByCategory(int $categoryId, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['categories', 'media'])
            ->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            })
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
