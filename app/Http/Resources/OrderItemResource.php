<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'variant_id' => $this->variant_id,
            'sku' => $this->sku,
            'product_name' => $this->name ?? $this->product?->getTranslation('name', app()->getLocale()) ?? 'Unknown Product',
            'variant_name' => $this->getVariantName(),
            'quantity' => $this->quantity,
            'price' => (float) $this->price,
            'subtotal' => (float) $this->total,
            'product' => $this->when($this->relationLoaded('product'), function () {
                return [
                    'id' => $this->product->id,
                    'slug' => $this->product->slug,
                    'name' => $this->product->getTranslation('name', app()->getLocale()),
                    'primary_image' => $this->product->getPrimaryImageUrl(),
                ];
            }),
        ];
    }
}
