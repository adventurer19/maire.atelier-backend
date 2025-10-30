<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'variant_id' => $this->variant_id,
            'token'      => $this->token,
            'user_id'    => $this->user_id,

            // ✅ Product details (compact format)
            'product' => new ProductResource($this->whenLoaded('product')),

            // ✅ Variant details if exist
            'variant' => new ProductVariantResource($this->whenLoaded('variant')),

            // ✅ Display helper
            'display_name' => $this->display_name,

            // 🕓 Meta
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
