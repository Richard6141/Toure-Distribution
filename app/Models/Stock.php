<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $primaryKey = 'stock_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'entrepot_id',
        'quantite',
        'reserved_quantity',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_id)) {
                $model->stock_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation : un stock appartient à un produit.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Relation : un stock appartient à un entrepôt.
     */
    public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_id', 'entrepot_id');
    }
}