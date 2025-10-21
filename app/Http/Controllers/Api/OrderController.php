<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * GET /api/orders
     * List all orders for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $orders = $this->orderService->getUserOrders($user);

        return $this->ok(OrderResource::collection($orders));
    }

    /**
     * GET /api/orders/{id}
     * Retrieve details of a single order by ID.
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $user = $request->user();
        $order = $this->orderService->getOrderById($id, $user);

        if (! $order) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'order_id' => $id,
            ], 404);
        }

        return $this->ok(new OrderResource($order));
    }

    /**
     * POST /api/orders
     * Create a new order from the current cart.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'address_id' => 'required|exists:addresses,id',
                'payment_method' => 'required|string|max:50',
                'notes' => 'nullable|string|max:500',
            ]);

            $user = $request->user();

            $order = $this->orderService->createOrder($user, $validated);

            return $this->created(new OrderResource($order));
        } catch (\Throwable $e) {
            return $this->error('ORDER_CREATION_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * PUT /api/orders/{id}/cancel
     * Cancel an existing order.
     */
    public function cancel(Request $request, string $id): JsonResponse
    {
        try {
            $user = $request->user();

            $order = $this->orderService->cancelOrder($id, $user);

            if (! $order) {
                return $this->error('NOT_FOUND', __('common.not_found'), [
                    'order_id' => $id,
                ], 404);
            }

            return $this->ok(new OrderResource($order));
        } catch (\Throwable $e) {
            return $this->error('ORDER_CANCEL_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * DELETE /api/orders/{id}
     * Delete an order (usually admin-only).
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $deleted = $this->orderService->deleteOrder($id);

            if (! $deleted) {
                return $this->error('NOT_FOUND', __('common.not_found'), [
                    'order_id' => $id,
                ], 404);
            }

            return $this->ok(['message' => __('Order deleted successfully')]);
        } catch (\Throwable $e) {
            return $this->error('ORDER_DELETE_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
