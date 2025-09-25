<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Fournisseur extends Model
{
    use SoftDeletes;

    protected $table = 'fournisseurs';
    protected $primaryKey = 'fournisseur_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'responsable',
        'adresse',
        'city',
        'phone',
        'email',
        'payment_terms',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->fournisseur_id)) {
                $model->fournisseur_id = (string) Str::uuid();
            }

            if (empty($model->code)) {
                $model->code = 'FRN-' . strtoupper(Str::random(6));
            }
        });
    }
}
