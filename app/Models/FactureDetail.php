<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FactureDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'facture_details';

    protected $primaryKey = 'facture_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'facture_id',
        'product_id',
        'quantite',
        'prix_unitaire',
        'montant_total',
        'taxe_rate',
        'discount_amount',
    ];

    protected $casts = [
        'quantite' => 'double',
        'prix_unitaire' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'taxe_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Relation avec la facture
     */
    public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id', 'id');
    }

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Calcul automatique du montant total avant enregistrement
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            $detail->montant_total = ($detail->quantite * $detail->prix_unitaire) - $detail->discount_amount;
        });
    }
}
