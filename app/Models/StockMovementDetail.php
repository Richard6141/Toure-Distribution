<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovementDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'stock_movement_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'stock_movement_id',
        'product_id',
        'quantity',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_movement_detail_id)) {
                $model->stock_movement_detail_id = (string) Str::uuid();
            }
        });
    }

    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class, 'stock_movement_id', 'stock_movement_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}