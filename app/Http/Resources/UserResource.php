<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'role'  => $this->role->value ?? null,
            'is_admin' => $this->isAdmin(),
            'is_customer' => $this->isCustomer(),
            'email_verified_at' => $this->email_verified_at?->toISOString(),

            // 🏠 Default Addresses
            'default_shipping' => new AddressResource($this->whenLoaded('defaultShippingAddress')),
            'default_billing'  => new AddressResource($this->whenLoaded('defaultBillingAddress')),

            // 📦 Relations (optional, load on demand)
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'orders'    => OrderResource::collection($this->whenLoaded('orders')),
            'wishlist'  => WishlistItemResource::collection($this->whenLoaded('wishlistItems')),

            // 🕓 Meta
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
