<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modèle pour les paiements clients effectués à la caisse
 *
 * Ce modèle enregistre les paiements effectués par les clients à la caisse
 * pour régler leurs dettes (solde négatif).
 */
class ClientPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_payments';
    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'client_id',
        'montant',
        'ancien_solde',
        'nouveau_solde',
        'mode_paiement',
        'numero_transaction',
        'numero_cheque',
        'banque',
        'note',
        'date_paiement',
        'caissier_id',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'ancien_solde' => 'decimal:2',
        'nouveau_solde' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    /**
     * Modes de paiement disponibles
     */
    const MODE_ESPECES = 'especes';
    const MODE_CHEQUE = 'cheque';
    const MODE_VIREMENT = 'virement';
    const MODE_MOBILE_MONEY = 'mobile_money';
    const MODE_CARTE = 'carte';

    /**
     * Boot method pour générer un UUID et la référence automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->payment_id)) {
                $model->payment_id = (string) Str::uuid();
            }

            if (empty($model->reference)) {
                $model->reference = self::generateReference();
            }

            if (empty($model->date_paiement)) {
                $model->date_paiement = now();
            }
        });
    }

    /**
     * Génère une référence unique pour le paiement
     * Format: PAY-CLI-YYYY-0001
     */
    public static function generateReference(): string
    {
        $year = date('Y');
        $prefix = "PAY-CLI-{$year}-";

        $lastPayment = self::withTrashed()
            ->where('reference', 'like', $prefix . '%')
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->reference, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation : le paiement appartient à un client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Relation : le paiement a été enregistré par un caissier (utilisateur)
     */
    public function caissier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caissier_id', 'user_id');
    }

    /**
     * Scope : filtrer par mode de paiement
     */
    public function scopeByModePaiement($query, string $mode)
    {
        return $query->where('mode_paiement', $mode);
    }

    /**
     * Scope : filtrer par client
     */
    public function scopeByClient($query, string $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope : filtrer par caissier
     */
    public function scopeByCaissier($query, string $caissierId)
    {
        return $query->where('caissier_id', $caissierId);
    }

    /**
     * Scope : filtrer par période
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_paiement', [$startDate, $endDate]);
    }

    /**
     * Scope : paiements du jour
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date_paiement', today());
    }

    /**
     * Accesseur : montant formaté
     */
    public function getFormattedMontantAttribute(): string
    {
        return number_format($this->montant, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : ancien solde formaté
     */
    public function getFormattedAncienSoldeAttribute(): string
    {
        return number_format($this->ancien_solde, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : nouveau solde formaté
     */
    public function getFormattedNouveauSoldeAttribute(): string
    {
        return number_format($this->nouveau_solde, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur : libellé du mode de paiement
     */
    public function getModePaiementLabelAttribute(): string
    {
        return match ($this->mode_paiement) {
            self::MODE_ESPECES => 'Espèces',
            self::MODE_CHEQUE => 'Chèque',
            self::MODE_VIREMENT => 'Virement bancaire',
            self::MODE_MOBILE_MONEY => 'Mobile Money',
            self::MODE_CARTE => 'Carte bancaire',
            default => $this->mode_paiement,
        };
    }

    /**
     * Retourne les modes de paiement disponibles
     */
    public static function getModesPaiement(): array
    {
        return [
            self::MODE_ESPECES => 'Espèces',
            self::MODE_CHEQUE => 'Chèque',
            self::MODE_VIREMENT => 'Virement bancaire',
            self::MODE_MOBILE_MONEY => 'Mobile Money',
            self::MODE_CARTE => 'Carte bancaire',
        ];
    }

    /**
     * Calcule la réduction de dette effectuée par ce paiement
     */
    public function getReductionDetteAttribute(): float
    {
        return $this->nouveau_solde - $this->ancien_solde;
    }
}
