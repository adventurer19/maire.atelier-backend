<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/products/{product}/reviews
     * List all reviews for a given product.
     */
    public function index(Product $product): JsonResponse
    {
        $reviews = $product->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return $this->ok(ReviewResource::collection($reviews), [
            'meta' => [
                'total' => $reviews->total(),
                'current_page' => $reviews->currentPage(),
            ]
        ]);
    }

    /**
     * GET /api/reviews/{id}
     * Show a single review.
     */
    public function show(string $id): JsonResponse
    {
        $review = Review::with(['user:id,name', 'product:id,name,slug'])
            ->find($id);

        if (! $review) {
            return $this->error('NOT_FOUND', __('common.not_found'), ['review_id' => $id], 404);
        }

        return $this->ok(new ReviewResource($review));
    }

    /**
     * POST /api/products/{product}/reviews
     * Create a new review (authenticated or guest).
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'guest_name'  => 'nullable|string|max:100',
            'guest_email' => 'nullable|email|max:255',
        ]);

        try {
            $review = new Review();
            $review->product_id = $product->id;
            $review->rating = $validated['rating'];
            $review->comment = $validated['comment'] ?? null;

            if ($user = $request->user()) {
                $review->user_id = $user->id;
            } else {
                $review->guest_name  = $validated['guest_name'] ?? 'Guest';
                $review->guest_email = $validated['guest_email'] ?? null;
            }

            $review->save();

            return $this->created(new ReviewResource($review));
        } catch (\Throwable $e) {
            return $this->error('REVIEW_CREATE_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * PUT /api/reviews/{id}
     * Update a review (only by owner).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $review = Review::find($id);

        if (! $review) {
            return $this->error('NOT_FOUND', __('common.not_found'), ['review_id' => $id], 404);
        }

        if ($review->user_id !== optional($request->user())->id) {
            return $this->error('FORBIDDEN', __('common.forbidden'), [], 403);
        }

        $validated = $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:2000',
        ]);

        $review->update($validated);

        return $this->ok(new ReviewResource($review->fresh()));
    }

    /**
     * DELETE /api/reviews/{id}
     * Delete a review (only by owner).
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $review = Review::find($id);

        if (! $review) {
            return $this->error('NOT_FOUND', __('common.not_found'), ['review_id' => $id], 404);
        }

        if ($review->user_id !== optional($request->user())->id) {
            return $this->error('FORBIDDEN', __('common.forbidden'), [], 403);
        }

        $review->delete();

        return $this->ok(['message' => __('Review deleted successfully')]);
    }
}
