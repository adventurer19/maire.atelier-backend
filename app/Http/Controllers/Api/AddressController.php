<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/addresses
     * List all addresses for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $addresses = $request->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return $this->ok(AddressResource::collection($addresses));
    }

    /**
     * POST /api/addresses
     * Create a new address for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['shipping', 'billing'])],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'company' => 'nullable|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|size:2',
            'phone' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = $request->user()->id;
        $address = Address::create($validated);

        // If new address is marked as default, reset others
        if ($address->is_default) {
            $address->setAsDefault();
        }

        return $this->created(new AddressResource($address));
    }

    /**
     * GET /api/addresses/{id}
     * Retrieve a specific address by ID (must belong to current user).
     */
    public function show(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return $this->error('FORBIDDEN', __('auth.forbidden'), [
                'address_id' => $address->id,
            ], 403);
        }

        return $this->ok(new AddressResource($address));
    }

    /**
     * PUT /api/addresses/{id}
     * Update an existing address (only if owned by user).
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return $this->error('FORBIDDEN', __('auth.forbidden'), [
                'address_id' => $address->id,
            ], 403);
        }

        $validated = $request->validate([
            'type' => ['sometimes', Rule::in(['shipping', 'billing'])],
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'company' => 'nullable|string|max:255',
            'address_line_1' => 'sometimes|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'sometimes|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
            'country' => 'sometimes|string|size:2',
            'phone' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        $address->update($validated);

        if (isset($validated['is_default']) && $validated['is_default']) {
            $address->setAsDefault();
        }

        return $this->ok(new AddressResource($address->fresh()));
    }

    /**
     * DELETE /api/addresses/{id}
     * Delete a specific address if owned by user.
     */
    public function destroy(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return $this->error('FORBIDDEN', __('auth.forbidden'), [
                'address_id' => $address->id,
            ], 403);
        }

        $wasDefault = $address->is_default;
        $type = $address->type;

        $address->delete();

        // If deleted address was default, assign a new default of same type
        if ($wasDefault) {
            $newDefault = Address::where('user_id', $request->user()->id)
                ->where('type', $type)
                ->first();

            if ($newDefault) {
                $newDefault->setAsDefault();
            }
        }

        return $this->ok(['message' => __('Address deleted successfully')]);
    }

    /**
     * POST /api/addresses/{id}/set-default
     * Mark the specified address as default for its type.
     */
    public function setDefault(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id !== $request->user()->id) {
            return $this->error('FORBIDDEN', __('auth.forbidden'), [
                'address_id' => $address->id,
            ], 403);
        }

        $address->setAsDefault();

        return $this->ok(new AddressResource($address->fresh()));
    }

    /**
     * GET /api/addresses/default/shipping
     * Get the user's default shipping address.
     */
    public function defaultShipping(Request $request): JsonResponse
    {
        $address = $request->user()
            ->addresses()
            ->shipping()
            ->default()
            ->first();

        if (! $address) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'type' => 'shipping'
            ], 404);
        }

        return $this->ok(new AddressResource($address));
    }

    /**
     * GET /api/addresses/default/billing
     * Get the user's default billing address.
     */
    public function defaultBilling(Request $request): JsonResponse
    {
        $address = $request->user()
            ->addresses()
            ->billing()
            ->default()
            ->first();

        if (! $address) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'type' => 'billing'
            ], 404);
        }

        return $this->ok(new AddressResource($address));
    }
}
