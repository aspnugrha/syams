<?php

namespace App\Http\Resources;

use App\Helpers\CodeHelper;
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
            'id_encode' => CodeHelper::encodeCode($this->id),
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'cover' => $this->cover,
            'image' => $this->image,
            'size_qty_options' => $this->size_qty_options,
            'active' => $this->active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
