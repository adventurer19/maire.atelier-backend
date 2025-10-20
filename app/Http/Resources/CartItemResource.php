<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'slug' => $this->product->slug,
                'sku' => $this->product->sku,
                'price' => $this->product->price,
                'image' => $this->product->getFirstMediaUrl('images', 'thumb'),
                'is_active' => $this->product->is_active,
                'stock' => $this->product->stock,
            ],
            'variant' => $this->when($this->variant, function () {
                return [
                    'id' => $this->variant->id,
                    'name' => $this->variant->name,
                    'sku' => $this->variant->sku,
                    'price' => $this->variant->price,
                    'stock' => $this->variant->stock,
                    'attributes' => $this->variant->attributes,
                ];
            }),
            'quantity' => $this->quantity,
            'price' => $this->price, // Per item price (variant or product)
            'subtotal' => $this->subtotal, // Price * quantity
            'has_enough_stock' => $this->hasEnoughStock(),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
