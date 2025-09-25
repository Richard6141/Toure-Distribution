<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'product_category_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'label',
        'description',
        'is_active',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->product_category_id)) {
                $model->product_category_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation avec les produits.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'product_category_id');
    }
}
