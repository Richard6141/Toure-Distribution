<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BanqueTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'banque_transaction_id' => $this->banque_transaction_id,
            'banque_account_id' => $this->banque_account_id,
            'transaction_number' => $this->transaction_number,
            'transaction_date' => $this->transaction_date,
            'transaction_type' => $this->transaction_type,
            'montant' => $this->montant,
            'libelle' => $this->libelle,
            'reference_externe' => $this->reference_externe,
            'tiers' => $this->tiers,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'account' => new BanqueAccountResource($this->whenLoaded('account')),
        ];
    }
}
