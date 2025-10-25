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
            'product_id' => $this->product_id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'product_category_id' => $this->product_category_id,
            'unit_price' => $this->unit_price,
            'unit_of_measure' => $this->unit_of_measure,
            'unit_weight' => $this->unit_weight,
            'cost' => $this->cost,
            'minimum_cost' => $this->minimum_cost,
            'min_stock_level' => $this->min_stock_level,
            'is_active' => $this->is_active,
            'picture' => $this->picture,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),

            // Relations
            'category' => $this->whenLoaded('category'),

            // Attributs calculés (optionnels)
            'has_tonnage_calculation' => $this->hasTonnageCalculation(),
        ];
    }
}
