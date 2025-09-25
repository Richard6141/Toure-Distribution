<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrepot extends Model
{
    use HasFactory, HasApiTokens, HasUuids;

    protected $primaryKey = 'entrepot_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'adresse',
        'is_active',
        'user_id',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->entrepot_id)) {
                $model->entrepot_id = (string) Str::uuid();
            }

            if (empty($model->code)) {
                $model->code = 'ENT-' . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relation : un entrepôt appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
