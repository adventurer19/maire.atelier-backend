<?php
// app/Http/Resources/ProductVariantResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => (float) $this->price,
            'stock_quantity' => $this->stock_quantity,
            'is_active' => $this->is_active,
            'is_in_stock' => $this->stock_quantity > 0,
            'attributes' => $this->attributeOptions->map(function ($option) {
                return [
                    'name' => $option->attribute->name,
                    'value' => $option->value,
                    'hex_color' => $option->hex_color,
                ];
            }),
            'variant_name' => $this->getVariantName(),
            'images' => $this->getMedia('images')->map(fn($media) => $media->getUrl()),
        ];
    }
}
