<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BanqueAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'banque_account_id' => $this->banque_account_id,
            'banque_id' => $this->banque_id,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'account_type' => $this->account_type,
            'titulaire' => $this->titulaire,
            'balance' => $this->balance,
            'statut' => $this->statut,
            'date_ouverture' => $this->date_ouverture,
            'isActive' => $this->isActive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'banque' => new BanqueResource($this->whenLoaded('banque')),
            'transactions' => BanqueTransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
