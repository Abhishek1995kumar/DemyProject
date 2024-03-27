<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryNameResource extends JsonResource {
    public function toArray($request) {
        return [
            'category_name' => $this->category->category_name,
            'sub_category_name' => $this->sub_category_name,
            'sub_category_slug' => $this->sub_category_slug,
        ];
    }
}
