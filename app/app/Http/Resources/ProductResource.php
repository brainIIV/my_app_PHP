<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'is_deleted' => (bool) $this->is_deleted,
            'is_published' => (bool) $this->is_published,
            'categories' => $this->categories->map(function ($category) {
                return $category->name;
            })
        ];
    }
}
