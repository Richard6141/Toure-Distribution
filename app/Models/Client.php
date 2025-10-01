<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'client_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name_client',
        'name_representant',
        'marketteur',
        'client_type_id',
        'adresse',
        'city',
        'email',
        'ifu',
        'phonenumber',
        'credit_limit',
        'current_balance',
        'base_reduction',
        'is_active',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'base_reduction' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->client_id)) {
                $model->client_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation : un client appartient à un type de client.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'client_type_id');
    }

    /**
     * Scope : clients actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope : clients inactifs
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope : recherche par nom
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name_client', 'like', "%{$name}%");
    }

    /**
     * Scope : recherche par email
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    /**
     * Scope : recherche par code
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', 'like', "%{$code}%");
    }

    /**
     * Scope : recherche par ville
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    /**
     * Scope : recherche par IFU
     */
    public function scopeByIfu($query, $ifu)
    {
        return $query->where('ifu', 'like', "%{$ifu}%");
    }

    /**
     * Scope : filtrer par type de client
     */
    public function scopeByClientType($query, $clientTypeId)
    {
        return $query->where('client_type_id', $clientTypeId);
    }

    /**
     * Scope : clients avec solde positif
     */
    public function scopeWithPositiveBalance($query)
    {
        return $query->where('current_balance', '>', 0);
    }

    /**
     * Scope : clients avec solde négatif
     */
    public function scopeWithNegativeBalance($query)
    {
        return $query->where('current_balance', '<', 0);
    }

    /**
     * Accesseur : crédit disponible
     */
    public function getAvailableCreditAttribute()
    {
        return $this->credit_limit - $this->current_balance;
    }

    /**
     * Accesseur : limite de crédit formatée
     */
    public function getFormattedCreditLimitAttribute()
    {
        return number_format($this->credit_limit, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : solde actuel formaté
     */
    public function getFormattedCurrentBalanceAttribute()
    {
        return number_format($this->current_balance, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : crédit disponible formaté
     */
    public function getFormattedAvailableCreditAttribute()
    {
        return number_format($this->available_credit, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : réduction de base formatée
     */
    public function getFormattedBaseReductionAttribute()
    {
        return number_format($this->base_reduction, 2, ',', ' ') . ' %';
    }

    /**
     * Méthode : mettre à jour le solde
     */
    public function updateBalance($amount)
    {
        $this->current_balance += $amount;
        $this->save();

        return $this;
    }
}
