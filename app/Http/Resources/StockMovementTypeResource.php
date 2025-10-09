<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stock_movement_type_id' => $this->stock_movement_type_id,
            'name' => $this->name,
            'direction' => $this->direction,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            
            // Relations
            'stock_movements_count' => $this->whenLoaded('stockMovements', function () {
                return $this->stockMovements->count();
            }),
            'stock_movements' => StockMovementResource::collection($this->whenLoaded('stockMovements')),
        ];
    }
}