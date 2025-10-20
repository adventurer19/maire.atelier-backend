<?php
// app/Http/Controllers/Api/ProductController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    /**
     * GET /api/products
     * Lista na vsi4ki produkti s paginacija
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 12);
        $categoryId = $request->input('category_id');

        $products = $categoryId
            ? $this->productRepository->filterByCategory($categoryId, $perPage)
            : $this->productRepository->getActivePaginated($perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * GET /api/products/featured
     * Featured products
     */
    public function featured(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 8);
        $products = $this->productRepository->getFeatured($limit);

        return response()->json([
            'data' => ProductResource::collection($products),
        ]);
    }

    /**
     * GET /api/products/{slug}
     * Edinen produkt po slug
     */
    public function show(string $slug): JsonResponse
    {
        $product = $this->productRepository->findBySlug($slug);

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * GET /api/search?q=dress
     * Tursene na produkti
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $perPage = $request->input('per_page', 12);

        if (!$query) {
            return response()->json([
                'message' => 'Search query is required',
                'data' => [],
            ], 400);
        }

        $products = $this->productRepository->search($query, $perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'query' => $query,
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
        ]);
    }
}
