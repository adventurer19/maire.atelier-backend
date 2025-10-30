<?php

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
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'sku' => $this->sku,

            // 🗣️ Translatable fields
            'name' => $this->getTranslation('name', $locale),
            'description' => $this->getTranslation('description', $locale),
            'short_description' => $this->getTranslation('short_description', $locale),
            'meta_title' => $this->getTranslation('meta_title', $locale),
            'meta_description' => $this->getTranslation('meta_description', $locale),

            // 💰 Pricing
            'price' => $this->price,
            'compare_at_price' => $this->compare_at_price,
            'discount_percentage' => $this->getDiscountPercentage(),
            'final_price' => $this->getFinalPrice(),

            // 📦 Stock info
            'is_in_stock' => $this->isInStock(),
            'is_low_stock' => $this->isLowStock(),
            'stock_quantity' => $this->stock_quantity,

            // ⚙️ Flags
            'is_active' => (bool) $this->is_active,
            'is_featured' => (bool) $this->is_featured,
            'requires_shipping' => (bool) $this->requires_shipping,

            // 🖼️ Images
            'thumbnail' => $this->getThumbnailUrl(),
            'primary_image' => $this->getPrimaryImageUrl(),
            'images' => $this->getAllImageUrls(),

            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id'   => $category->id,
                        'slug' => $category->slug,
                        'name' => $category->getTranslation('name', app()->getLocale()),
                    ];
                });
            }),

            'variants' => $this->whenLoaded('variants', function () {
                return ProductVariantResource::collection(
                    $this->variants->map->withoutRelations()
                );
            }),

            // 📆 Meta
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}
