<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stock_movement_id' => $this->stock_movement_id,
            'reference' => $this->reference,
            'movement_type_id' => $this->movement_type_id,
            'entrepot_from_id' => $this->entrepot_from_id,
            'entrepot_to_id' => $this->entrepot_to_id,
            'fournisseur_id' => $this->fournisseur_id,
            'client_id' => $this->client_id,
            'statut' => $this->statut,
            'note' => $this->note,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            
            // Relations
            'movement_type' => new StockMovementTypeResource($this->whenLoaded('movementType')),
            'entrepot_from' => new EntrepotResource($this->whenLoaded('entrepotFrom')),
            'entrepot_to' => new EntrepotResource($this->whenLoaded('entrepotTo')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'user' => new UserResource($this->whenLoaded('user')),
            'details_count' => $this->whenLoaded('details', function () {
                return $this->details->count();
            }),
            'details' => StockMovementDetailResource::collection($this->whenLoaded('details')),
        ];
    }
}