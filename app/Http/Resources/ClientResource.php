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
            'phonenumber' => $this->phonenumber,
            'credit_limit' => $this->credit_limit,
            'current_balance' => $this->current_balance,
            'base_reduction' => $this->base_reduction,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),

            // Champs calculés
            'available_credit' => $this->available_credit ?? ($this->credit_limit - $this->current_balance),

            // Champs formatés pour l'affichage
            'formatted_credit_limit' => number_format($this->credit_limit, 2, ',', ' ') . ' FCFA',
            'formatted_current_balance' => number_format($this->current_balance, 2, ',', ' ') . ' FCFA',
            'formatted_available_credit' => number_format(($this->credit_limit - $this->current_balance), 2, ',', ' ') . ' FCFA',
            'formatted_base_reduction' => number_format($this->base_reduction, 2, ',', ' ') . ' %',

            // Relation avec le type de client (chargée conditionnellement)
            'client_type' => $this->whenLoaded('clientType', function () {
                return new ClientTypeResource($this->clientType);
            }),
        ];
    }
}
