<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BanqueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'banque_id' => $this->banque_id,
            'name' => $this->name,
            'code' => $this->code,
            'adresse' => $this->adresse,
            'contact_info' => $this->contact_info,
            'isActive' => $this->isActive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'accounts_count' => $this->when($this->accounts_count !== null, $this->accounts_count),
            'accounts' => BanqueAccountResource::collection($this->whenLoaded('accounts')),
        ];
    }
}