<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'stock_movement_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'movement_type_id',
        'entrepot_from_id',
        'entrepot_to_id',
        'fournisseur_id',
        'client_id',
        'statut',
        'note',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_movement_id)) {
                $model->stock_movement_id = (string) Str::uuid();
            }
        });
    }

    public function movementType()
    {
        return $this->belongsTo(StockMovementType::class, 'movement_type_id', 'stock_movement_type_id');
    }

    public function entrepotFrom()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_from_id', 'entrepot_id');
    }

    public function entrepotTo()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_to_id', 'entrepot_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(StockMovementDetail::class, 'stock_movement_id', 'stock_movement_id');
    }
}