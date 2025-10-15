<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailCommande extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Le nom de la clé primaire
     */
    protected $primaryKey = 'detail_commande_id';

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
        'commande_id',
        'product_id',
        'quantite',
        'prix_unitaire',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'sous_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Les attributs à ajouter dans les résultats JSON
     */
    protected $appends = ['sous_total'];

    /**
     * Relation avec la commande
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'commande_id');
    }

    /**
     * Relation avec le produit
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Calcule le sous-total (quantité * prix unitaire)
     * Utilisé si la colonne calculée n'est pas disponible
     */
    public function getSousTotalAttribute(): float
    {
        // Si la colonne calculée existe dans les attributes, l'utiliser
        if (isset($this->attributes['sous_total'])) {
            return (float) $this->attributes['sous_total'];
        }

        // Sinon, calculer manuellement
        return $this->quantite * $this->prix_unitaire;
    }

    /**
     * Scope pour filtrer par commande
     */
    public function scopeParCommande($query, $commandeId)
    {
        return $query->where('commande_id', $commandeId);
    }

    /**
     * Scope pour filtrer par produit
     */
    public function scopeParProduit($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
