<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailVente extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'detail_vente_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'vente_id',
        'product_id',
        'quantite',
        'prix_unitaire',
        'remise_ligne',
        'montant_ht',
        'taux_taxe',
        'montant_taxe',
        'montant_ttc',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'remise_ligne' => 'decimal:2',
        'montant_ht' => 'decimal:2',
        'taux_taxe' => 'decimal:2',
        'montant_taxe' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    /**
     * Relation avec la vente
     */
    public function vente(): BelongsTo
    {
        return $this->belongsTo(Vente::class, 'vente_id', 'vente_id');
    }

    /**
     * Relation avec le produit
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Calcule automatiquement les montants avant la sauvegarde
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            // Calcul du montant HT (après remise)
            $montantBrut = $detail->quantite * $detail->prix_unitaire;
            $detail->montant_ht = $montantBrut - $detail->remise_ligne;

            // Calcul de la taxe
            $detail->montant_taxe = $detail->montant_ht * ($detail->taux_taxe / 100);

            // Calcul du montant TTC
            $detail->montant_ttc = $detail->montant_ht + $detail->montant_taxe;
        });
    }
}
