<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\DetailCommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'description',
        'product_category_id',
        'unit_price',
        'unit_of_measure',
        'unit_weight',
        'cost',
        'minimum_cost',
        'min_stock_level',
        'is_active',
        'picture',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'minimum_cost' => 'decimal:2',
        'unit_weight' => 'decimal:4',
        'min_stock_level' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->product_id)) {
                $model->product_id = (string) Str::uuid();
            }
            if (empty($model->code)) {
                $model->code = 'PRO-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relation : un produit appartient à une catégorie.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'product_category_id');
    }

    /**
     * Relation avec les détails de commandes
     */
    public function detailCommandes()
    {
        return $this->hasMany(DetailCommande::class, 'product_id', 'product_id');
    }

    /**
     * Scope pour obtenir uniquement les produits actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculer le tonnage pour une quantité donnée
     * 
     * @param float $quantity
     * @return float|null Tonnage en tonnes
     */
    public function calculateTonnage(float $quantity): ?float
    {
        if (!$this->unit_weight) {
            return null;
        }

        // Convertir kg en tonnes
        return ($quantity * $this->unit_weight) / 1000;
    }

    /**
     * Obtenir le poids total pour une quantité donnée en kg
     * 
     * @param float $quantity
     * @return float|null Poids en kg
     */
    public function getTotalWeight(float $quantity): ?float
    {
        if (!$this->unit_weight) {
            return null;
        }

        return $quantity * $this->unit_weight;
    }

    /**
     * Vérifier si le produit nécessite un calcul de tonnage
     * 
     * @return bool
     */
    public function hasTonnageCalculation(): bool
    {
        return !is_null($this->unit_weight) && $this->unit_weight > 0;
    }
}
