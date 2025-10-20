<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Display a listing of user's addresses.
     * GET /api/addresses
     */
    public function index(Request $request): JsonResponse
    {
        $addresses = $request->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => AddressResource::collection($addresses),
        ]);
    }

    /**
     * Store a newly created address.
     * POST /api/addresses
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
            'country' => 'required|string|size:2', // ISO code (BG, US, etc)
            'phone' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = $request->user()->id;

        $address = Address::create($validated);

        // Ако е маркиран като default, премахни default от останалите
        if ($address->is_default) {
            $address->setAsDefault();
        }

        return response()->json([
            'message' => __('Address created successfully'),
            'data' => new AddressResource($address),
        ], 201);
    }

    /**
     * Display the specified address.
     * GET /api/addresses/{id}
     */
    public function show(Request $request, Address $address): JsonResponse
    {
        // Провери дали адреса принадлежи на текущия user
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
                'error' => 'ADDRESS_NOT_OWNED',
            ], 403);
        }

        return response()->json([
            'data' => new AddressResource($address),
        ]);
    }

    /**
     * Update the specified address.
     * PUT /api/addresses/{id}
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        // Провери ownership
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
                'error' => 'ADDRESS_NOT_OWNED',
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

        // Ако е маркиран като default, премахни default от останалите
        if (isset($validated['is_default']) && $validated['is_default']) {
            $address->setAsDefault();
        }

        return response()->json([
            'message' => __('Address updated successfully'),
            'data' => new AddressResource($address->fresh()),
        ]);
    }

    /**
     * Remove the specified address.
     * DELETE /api/addresses/{id}
     */
    public function destroy(Request $request, Address $address): JsonResponse
    {
        // Провери ownership
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
                'error' => 'ADDRESS_NOT_OWNED',
            ], 403);
        }

        // Запази type и is_default преди изтриване
        $wasDefault = $address->is_default;
        $type = $address->type;

        $address->delete();

        // Ако изтритият адрес е бил default, направи друг адрес default
        if ($wasDefault) {
            $newDefault = Address::where('user_id', $request->user()->id)
                ->where('type', $type)
                ->first();

            if ($newDefault) {
                $newDefault->setAsDefault();
            }
        }

        return response()->json([
            'message' => __('Address deleted successfully'),
        ]);
    }

    /**
     * Set address as default.
     * POST /api/addresses/{id}/set-default
     */
    public function setDefault(Request $request, Address $address): JsonResponse
    {
        // Провери ownership
        if ($address->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden',
                'error' => 'ADDRESS_NOT_OWNED',
            ], 403);
        }

        $address->setAsDefault();

        return response()->json([
            'message' => __('Default address updated'),
            'data' => new AddressResource($address->fresh()),
        ]);
    }

    /**
     * Get default shipping address.
     * GET /api/addresses/default/shipping
     */
    public function defaultShipping(Request $request): JsonResponse
    {
        $address = $request->user()
            ->addresses()
            ->shipping()
            ->default()
            ->first();

        if (!$address) {
            return response()->json([
                'message' => 'No default shipping address found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'data' => new AddressResource($address),
        ]);
    }

    /**
     * Get default billing address.
     * GET /api/addresses/default/billing
     */
    public function defaultBilling(Request $request): JsonResponse
    {
        $address = $request->user()
            ->addresses()
            ->billing()
            ->default()
            ->first();

        if (!$address) {
            return response()->json([
                'message' => 'No default billing address found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'data' => new AddressResource($address),
        ]);
    }
}
