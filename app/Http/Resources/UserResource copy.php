<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Informations de base
            'user_id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->firstname . ' ' . $this->lastname,
            'phonenumber' => $this->phonenumber,
            'poste' => $this->poste,

            // Statut du compte
            'is_active' => $this->is_active,
            'email_verified_at' => $this->email_verified_at?->format('Y-m-d H:i:s'),
            'is_email_verified' => $this->isEmailVerified(),

            // Informations de sécurité
            'last_login_at' => $this->last_login_at?->format('Y-m-d H:i:s'),
            'last_login_ip' => $this->last_login_ip,
            'failed_login_attempts' => $this->failed_login_attempts ?? 0,

            // Informations de verrouillage
            'is_locked' => $this->isLocked(),
            'locked_until' => $this->locked_until?->format('Y-m-d H:i:s'),
            'remaining_lock_time' => $this->when($this->isLocked(), function () {
                return $this->getRemainingLockTime() . ' minutes';
            }),

            // Gestion du mot de passe
            'password_changed_at' => $this->password_changed_at?->format('Y-m-d H:i:s'),
            'should_change_password' => $this->shouldChangePassword(),

            // Rôles et permissions (si utilisés)
            'roles' => $this->when($this->relationLoaded('roles'), function () {
                return $this->roles->pluck('name');
            }),
            'permissions' => $this->when($this->relationLoaded('permissions'), function () {
                return $this->permissions->pluck('name');
            }),

            // Timestamps
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
