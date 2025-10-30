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
        $locale = app()->getLocale(); // SetLocale middleware already handled this

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'sku' => $this->sku,

            // 🗣️ Translatable fields
            'name' => $this->getTranslation('name', $locale),
            'description' => $this->getTranslation('description', $locale),
            'short_description' => $this->getTranslation('short_description', $locale),
            'material' => $this->getTranslation('material', $locale),
            'care_instructions' => $this->getTranslation('care_instructions', $locale),
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
            'stock_status' => $this->stock_status,

            // ⚙️ Flags
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'requires_shipping' => $this->requires_shipping,
            'is_taxable' => $this->is_taxable,

            // ⚖️ Dimensions
            'weight' => $this->weight,
            'width' => $this->width,
            'height' => $this->height,
            'depth' => $this->depth,

            // 🖼️ Images
            'thumbnail' => $this->getThumbnailUrl(),
            'primary_image' => $this->getPrimaryImageUrl(),
            'images' => $this->getAllImageUrls(),

            // 🔗 Relationships (lazy loaded only if requested with ->load())
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'collections' => CollectionResource::collection($this->whenLoaded('collections')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),

            // 📆 Meta
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
