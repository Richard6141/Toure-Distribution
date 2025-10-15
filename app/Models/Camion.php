<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camion extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Le nom de la clé primaire
     */
    protected $primaryKey = 'camion_id';

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
        'numero_immat',
        'marque',
        'modele',
        'capacite',
        'status',
        'note',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'capacite' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Vérifie si le camion est disponible
     */
    public function isDisponible(): bool
    {
        return $this->status === 'disponible';
    }

    /**
     * Vérifie si le camion est en mission
     */
    public function isEnMission(): bool
    {
        return $this->status === 'en_mission';
    }

    /**
     * Vérifie si le camion est en maintenance
     */
    public function isEnMaintenance(): bool
    {
        return $this->status === 'en_maintenance';
    }

    /**
     * Scope pour obtenir uniquement les camions disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('status', 'disponible');
    }

    /**
     * Scope pour obtenir les camions en mission
     */
    public function scopeEnMission($query)
    {
        return $query->where('status', 'en_mission');
    }

    /**
     * Scope pour filtrer par capacité minimale
     */
    public function scopeCapaciteMin($query, $capacite)
    {
        return $query->where('capacite', '>=', $capacite);
    }

    /**
     * Scope pour filtrer par capacité maximale
     */
    public function scopeCapaciteMax($query, $capacite)
    {
        return $query->where('capacite', '<=', $capacite);
    }
}
