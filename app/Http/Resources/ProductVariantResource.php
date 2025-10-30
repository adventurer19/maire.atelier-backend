<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'sku' => $this->getSku(),

            // 💰 Pricing
            'price' => $this->price,
            'final_price' => $this->getFinalPrice(),

            // 📦 Stock
            'is_active' => $this->is_active,
            'is_in_stock' => $this->isInStock(),
            'stock_quantity' => $this->stock_quantity,

            // 🖼️ Images (fallback to product if empty)
            'thumbnail' => $this->getThumbnailUrl(),
            'primary_image' => $this->getPrimaryImageUrl(),
            'images' => $this->getAllImageUrls(),

            // 🎨 Attributes (translated values)
            'attributes' => $this->attributeOptions->map(function ($option) use ($locale) {
                return [
                    'id' => $option->id,
                    'slug' => $option->attribute->slug,
                    'name' => $option->attribute->getTranslation('name', $locale),
                    'value' => $option->getTranslation('value', $locale),
                    'hex_color' => $option->hex_color,
                ];
            }),

            // 🏷️ Human-readable label (e.g. “Red / M - 49.99 BGN”)
            'label' => $this->getFormattedLabel(),

            // 🔗 Optional relation back to product (if loaded)
            'product' => new ProductResource($this->whenLoaded('product')),

            // 🕓 Timestamps
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
