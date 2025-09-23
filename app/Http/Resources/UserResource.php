<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'phonenumber' => $this->phonenumber,
            'poste' => $this->poste,
            'is_active' => (bool) $this->is_active,
            'email_verified' => $this->isEmailVerified(),
            'last_login_at' => $this->last_login_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            // Champs conditionnels (seulement pour l'utilisateur connecté)
            $this->mergeWhen($request->user()?->user_id === $this->user_id, [
                'should_change_password' => $this->shouldChangePassword(),
                'account_locked' => $this->isLocked(),
                'failed_attempts' => (int) $this->failed_login_attempts,
                'remaining_lock_time' => $this->getRemainingLockTime(),
            ]),

            // Timestamps supplémentaires pour l'utilisateur connecté
            $this->mergeWhen($request->user()?->user_id === $this->user_id, [
                'password_changed_at' => $this->password_changed_at?->format('Y-m-d H:i:s'),
                'locked_until' => $this->locked_until?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ]),
        ];
    }
}