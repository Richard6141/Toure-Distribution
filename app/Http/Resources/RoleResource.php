<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,

            // Permissions du rôle
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'permission_names' => $this->when(
                $this->relationLoaded('permissions'),
                fn() => $this->permissions->pluck('name')
            ),
            'permissions_count' => $this->when(
                $this->relationLoaded('permissions'),
                fn() => $this->permissions->count()
            ),

            // Nombre d'utilisateurs ayant ce rôle
            'users_count' => $this->when(
                $this->users_count !== null,
                $this->users_count
            ),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
