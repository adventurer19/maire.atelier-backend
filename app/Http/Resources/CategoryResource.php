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

        $t = function (string $field) use ($locale, $model) {
            try {
                if (!method_exists($model, 'getTranslation')) {
                    return $model->{$field} ?? '';
                }
                $value = $model->getTranslation($field, $locale, false);

                return $value ?: ($model->{$field} ?? '');
            } catch (\Throwable) {
                return $model->{$field} ?? '';
            }
        };


        return [
            'id' => $model->id,
            'slug' => $model->slug,
            'parent_id' => $model->parent_id,
            'name' => $t('name'),
            'description' => $t('description'),
            'meta_title' => $t('meta_title'),
            'meta_description' => $t('meta_description'),

            'is_active' => (bool) $model->is_active,
            'is_featured' => (bool) $model->is_featured,
            'show_in_menu' => (bool) $model->show_in_menu,

            'products' => $this->when(
                $request->routeIs('categories.show'),
                fn() => $this->whenLoaded('products', function () use ($locale) {
                    return $this->products->map(function ($product) use ($locale) {
                        return [
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'name' => $product->getTranslation('name', $locale),
                            'price' => $product->price,
                            'thumbnail' => $product->getThumbnailUrl(),
                        ];
                    });
                })
            ),
        ];
    }
}
