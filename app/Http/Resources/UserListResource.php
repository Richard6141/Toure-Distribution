<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Resource simplifiée pour les listes d'utilisateurs
     * Optimisée pour la performance avec Spatie Laravel Permission
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->firstname . ' ' . $this->lastname,
            'phonenumber' => $this->phonenumber,
            'poste' => $this->poste,
            'is_active' => $this->is_active,
            'is_locked' => $this->isLocked(),
            'last_login_at' => $this->last_login_at?->format('Y-m-d H:i:s'),

            // Rôles Spatie (noms uniquement pour performance)
            'role_names' => $this->getRoleNames(),

            // Nombre de permissions (utile pour les tableaux)
            'permissions_count' => $this->when(
                $this->relationLoaded('permissions'),
                fn() => $this->permissions->count()
            ),
        ];
    }
}
