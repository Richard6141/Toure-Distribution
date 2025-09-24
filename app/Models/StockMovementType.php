<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovementType extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'stock_movement_type_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'direction',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_movement_type_id)) {
                $model->stock_movement_type_id = (string) Str::uuid();
            }
        });
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'movement_type_id', 'stock_movement_type_id');
    }
}
