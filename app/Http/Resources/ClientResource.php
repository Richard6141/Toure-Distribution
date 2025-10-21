<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'client_id' => $this->client_id,
            'code' => $this->code,
            'name_client' => $this->name_client,
            'name_representant' => $this->name_representant,
            'marketteur' => $this->marketteur,
            'client_type_id' => $this->client_type_id,
            'adresse' => $this->adresse,
            'city' => $this->city,
            'email' => $this->email,
            'ifu' => $this->ifu,

            // Numéros de téléphone
            'phones' => ClientPhoneResource::collection($this->whenLoaded('phones')),

            // Compatibilité avec l'ancien champ (retourne le premier numéro)
            'phonenumber' => $this->phonenumber, // Via accessor

            'credit_limit' => $this->credit_limit,
            'current_balance' => $this->current_balance,
            'base_reduction' => $this->base_reduction,
            'is_active' => $this->is_active,

            // Champs calculés (si disponibles dans votre modèle)
            'formatted_credit_limit' => $this->when(
                method_exists($this->resource, 'getFormattedCreditLimitAttribute'),
                $this->formatted_credit_limit
            ),
            'formatted_current_balance' => $this->when(
                method_exists($this->resource, 'getFormattedCurrentBalanceAttribute'),
                $this->formatted_current_balance
            ),
            'available_credit' => $this->when(
                method_exists($this->resource, 'getAvailableCreditAttribute'),
                $this->available_credit
            ),
            'formatted_available_credit' => $this->when(
                method_exists($this->resource, 'getFormattedAvailableCreditAttribute'),
                $this->formatted_available_credit
            ),
            'formatted_base_reduction' => $this->when(
                method_exists($this->resource, 'getFormattedBaseReductionAttribute'),
                $this->formatted_base_reduction
            ),

            // Type de client
            'client_type' => $this->whenLoaded('clientType'),

            // Timestamps
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
