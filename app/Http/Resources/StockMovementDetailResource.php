<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stock_movement_detail_id' => $this->stock_movement_detail_id,
            'stock_movement_id' => $this->stock_movement_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            
            // Relations
            'stock_movement' => new StockMovementResource($this->whenLoaded('stockMovement')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}