<?php

use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    use SoftDeletes, HasUuids, SoftDeletes;

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

    /**
     * Relation avec les commandes
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'fournisseur_id', 'fournisseur_id');
    }

    /**
     * Scope pour obtenir uniquement les fournisseurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }
}
