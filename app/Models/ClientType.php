<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientType extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $primaryKey = 'client_type_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'label',
        'description',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->client_type_id)) {
                $model->client_type_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation avec les clients (si tu as une table `clients`).
     * Exemple :
     * return $this->hasMany(Client::class, 'client_type_id', 'client_type_id');
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'client_type_id', 'client_type_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour recherche par label
     */
    public function scopeByLabel($query, $label)
    {
        return $query->where('label', 'like', "%{$label}%");
    }

    /**
     * Accessor pour formater le credit_limit
     */
    public function getFormattedCreditLimitAttribute()
    {
        return number_format($this->credit_limit, 2, ',', ' ') . ' €';
    }
}
