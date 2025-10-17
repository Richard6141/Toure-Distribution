<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'fournisseurs';
    protected $primaryKey = 'fournisseur_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'responsable',
        'adresse',
        'city',
        'phone',
        'email',
        'payment_terms',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->fournisseur_id)) {
                $model->fournisseur_id = (string) Str::uuid();
            }

            if (empty($model->code)) {
                $model->code = 'FRS-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);
            }
        });
    }

    /**
     * Relation avec les commandes
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'fournisseur_id', 'fournisseur_id');
    }

    /**
     * Scope pour obtenir uniquement les fournisseurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour obtenir les fournisseurs inactifs
     */
    public function scopeInactifs($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope pour rechercher par nom
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * Scope pour rechercher par ville
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    /**
     * Vérifie si le fournisseur est actif
     */
    public function isActif(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Calcule le total des commandes du fournisseur
     */
    public function getTotalCommandesAttribute(): float
    {
        return $this->commandes()
            ->whereNotIn('status', ['annulee'])
            ->sum('montant');
    }

    /**
     * Compte le nombre de commandes du fournisseur
     */
    public function getNombreCommandesAttribute(): int
    {
        return $this->commandes()->count();
    }
}
