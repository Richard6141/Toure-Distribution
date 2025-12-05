<?php

namespace App\Models;

use App\Models\ClientPhone;
use App\Models\ClientPayment;
use App\Models\ClientBalanceAdjustment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Relation avec les ventes
     */
    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class, 'client_id', 'client_id');
    }

    /**
     * Calcule le total des ventes du client
     */
    public function getTotalVentesAttribute(): float
    {
        return $this->ventes()->where('status', '!=', 'annulee')->sum('montant_net');
    }

    /**
     * Calcule le total des impayés du client
     */
    public function getTotalImpayesAttribute(): float
    {
        return $this->ventes()
            ->whereIn('statut_paiement', ['non_paye', 'paye_partiellement'])
            ->get()
            ->sum(function ($vente) {
                return $vente->montant_restant;
            });
    }

    /**
     * Relation avec les ajustements de solde
     */
    public function balanceAdjustments(): HasMany
    {
        return $this->hasMany(ClientBalanceAdjustment::class, 'client_id', 'client_id');
    }

    /**
     * Relation avec les paiements caisse
     */
    public function clientPayments(): HasMany
    {
        return $this->hasMany(ClientPayment::class, 'client_id', 'client_id');
    }

    /**
     * Récupère la dette initiale migrée (si existante)
     * Note: Les dettes sont stockées en négatif, on retourne la valeur absolue
     */
    public function getDetteInitialeAttribute(): float
    {
        $montant = $this->balanceAdjustments()
            ->where('type', 'dette_initiale')
            ->where('source', 'migration')
            ->sum('montant');

        return abs($montant);
    }

    /**
     * Récupère la dette initiale formatée
     */
    public function getFormattedDetteInitialeAttribute(): string
    {
        return number_format($this->dette_initiale, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Récupère la dette actuelle du client (solde négatif = dette)
     */
    public function getDetteActuelleAttribute(): float
    {
        return $this->current_balance < 0 ? abs($this->current_balance) : 0;
    }

    /**
     * Récupère la dette actuelle formatée
     */
    public function getFormattedDetteActuelleAttribute(): string
    {
        return number_format($this->dette_actuelle, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Vérifie si le client a une dette (solde négatif)
     */
    public function hasDebt(): bool
    {
        return $this->current_balance < 0;
    }

    /**
     * Vérifie si le client a un crédit/avance (solde positif)
     */
    public function hasCredit(): bool
    {
        return $this->current_balance > 0;
    }

    /**
     * Vérifie si le client a une dette de migration
     */
    public function hasMigrationDebt(): bool
    {
        return $this->balanceAdjustments()
            ->where('type', 'dette_initiale')
            ->where('source', 'migration')
            ->exists();
    }

    /**
     * Scope : clients avec dette de migration
     */
    public function scopeWithMigrationDebt($query)
    {
        return $query->whereHas('balanceAdjustments', function ($q) {
            $q->where('type', 'dette_initiale')->where('source', 'migration');
        });
    }

    /**
     * Retourne le total des ajustements (positifs et négatifs)
     */
    public function getTotalAdjustmentsAttribute(): float
    {
        return $this->balanceAdjustments()->sum('montant');
    }

    /**
     * Retourne le total des paiements caisse effectués par le client
     */
    public function getTotalClientPaymentsAttribute(): float
    {
        return $this->clientPayments()->sum('montant');
    }

    /**
     * Retourne le total des paiements caisse formaté
     */
    public function getFormattedTotalClientPaymentsAttribute(): string
    {
        return number_format($this->total_client_payments, 2, ',', ' ') . ' FCFA';
    }
}
