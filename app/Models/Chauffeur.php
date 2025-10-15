<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chauffeur extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Le nom de la clé primaire
     */
    protected $primaryKey = 'chauffeur_id';

    /**
     * Indique si la clé primaire est auto-incrémentée
     */
    public $incrementing = false;

    /**
     * Le type de la clé primaire
     */
    protected $keyType = 'string';

    /**
     * Les attributs assignables en masse
     */
    protected $fillable = [
        'name',
        'phone',
        'numero_permis',
        'date_expiration_permis',
        'status',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'date_expiration_permis' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Vérifie si le permis est expiré
     */
    public function isPermisExpire(): bool
    {
        return $this->date_expiration_permis < now();
    }

    /**
     * Vérifie si le chauffeur est actif
     */
    public function isActif(): bool
    {
        return $this->status === 'actif';
    }

    /**
     * Scope pour obtenir uniquement les chauffeurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('status', 'actif');
    }

    /**
     * Scope pour obtenir les chauffeurs avec permis valide
     */
    public function scopePermisValide($query)
    {
        return $query->where('date_expiration_permis', '>=', now());
    }
}
