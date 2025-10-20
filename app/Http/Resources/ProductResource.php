<?php
// app/Http/Resources/ProductResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'name' => $this->name, // translatable (bg/en)
            'description' => $this->description,
            'short_description' => $this->short_description,
            'material' => $this->material,
            'care_instructions' => $this->care_instructions,

            // Pricing
            'price' => (float) $this->price,
            'sale_price' => $this->sale_price ? (float) $this->sale_price : null,
            'compare_at_price' => $this->compare_at_price ? (float) $this->compare_at_price : null,
            'final_price' => $this->sale_price ? (float) $this->sale_price : (float) $this->price,
            'discount_percentage' => $this->getDiscountPercentage(),

            // Stock
            'stock_quantity' => $this->stock_quantity,
            'is_in_stock' => $this->stock_quantity > 0,
            'low_stock_threshold' => $this->low_stock_threshold,
            'is_low_stock' => $this->stock_quantity <= $this->low_stock_threshold && $this->stock_quantity > 0,

            // Status
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,

            // Dimensions (optional)
            'weight' => $this->weight,
            'dimensions' => [
                'width' => $this->width,
                'height' => $this->height,
                'depth' => $this->depth,
            ],

            // Relationships
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'images' => $this->getAllImageUrls(),
            'primary_image' => $this->getPrimaryImageUrl(),

            // Meta
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,

            // Timestamps
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    /**
     * Calculate discount percentage
     */
    private function getDiscountPercentage(): ?int
    {
        if (!$this->sale_price || !$this->price) {
            return null;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }
}
