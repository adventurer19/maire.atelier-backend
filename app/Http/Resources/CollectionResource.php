<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'type' => $this->type, // e.g. "manual" | "auto"

            // 🗣️ Translatable fields
            'name' => $this->getTranslation('name', $locale),
            'description' => $this->getTranslation('description', $locale),
            'meta_title' => $this->getTranslation('meta_title', $locale),
            'meta_description' => $this->getTranslation('meta_description', $locale),

            // 🖼️ Image
            'image' => $this->image ? (
            str_starts_with($this->image, 'http')
                ? $this->image
                : asset('storage/' . $this->image)
            ) : null,

            // ⚙️ Flags
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'position' => $this->position,

            // 🧠 Conditions (for smart/auto collections)
            'conditions' => $this->conditions ?? null,

            // 🛍️ Related products (only if loaded)
            'products' => ProductResource::collection($this->whenLoaded('products')),

            // 🕓 Meta
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
