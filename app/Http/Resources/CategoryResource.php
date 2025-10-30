<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $model = $this->resource;

        // Safe translation helper
        $t = function (string $field) use ($locale, $model) {
            try {
                if (method_exists($model, 'getTranslation')) {
                    $value = $model->getTranslation($field, $locale);
                    return !empty($value) ? $value : ($model->{$field} ?? '');
                }
                return $model->{$field} ?? '';
            } catch (\Throwable $e) {
                return $model->{$field} ?? '';
            }
        };

        return [
            'id' => $model->id,
            'slug' => $model->slug,
            'parent_id' => $model->parent_id,

            // 🗣️ Translatable fields
            'name' => $t('name'),
            'description' => $t('description'),
            'meta_title' => $t('meta_title'),
            'meta_description' => $t('meta_description'),

            // 🖼️ Image
//            'image' => $model->image_url,

            // ⚙️ Flags
//            'is_active' => (bool) $model->is_active,
//            'is_featured' => (bool) $model->is_featured,
//            'show_in_menu' => (bool) $model->show_in_menu,
//            'position' => $model->position,

//            // 🧭 Navigation (safe)
//            'has_children' => (bool) $model->children()->exists(),
//            'path' => $this->when(filled($model->parent_id), fn() => $model->getFullPath()),
//
//            // 🔗 Relationships (safe)
//            'parent' => $this->whenLoaded('parent', fn() => new CategoryResource($model->parent->withoutRelations())),
//            'children' => $this->whenLoaded('children', fn() => CategoryResource::collection($model->children->map->withoutRelations())),
//
//            // 🛍️ Products (само при /api/categories/{slug})
//            'products' => $this->when(
//                $request->routeIs('categories.show'),
//                fn() => ProductResource::collection($this->whenLoaded('products'))
//            ),
//
//            // 🕓 Meta
//            'created_at' => optional($model->created_at)->toISOString(),
//            'updated_at' => optional($model->updated_at)->toISOString(),
        ];
    }
}
