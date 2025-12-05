<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientBalanceAdjustment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_balance_adjustments';
    protected $primaryKey = 'adjustment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'client_id',
        'type',
        'montant',
        'ancien_solde',
        'nouveau_solde',
        'motif',
        'note',
        'source',
        'date_ajustement',
        'user_id',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'ancien_solde' => 'decimal:2',
        'nouveau_solde' => 'decimal:2',
        'date_ajustement' => 'datetime',
    ];

    /**
     * Types d'ajustement disponibles
     */
    const TYPE_DETTE_INITIALE = 'dette_initiale';
    const TYPE_AJUSTEMENT_CREDIT = 'ajustement_credit';
    const TYPE_AJUSTEMENT_DEBIT = 'ajustement_debit';
    const TYPE_CORRECTION = 'correction';
    const TYPE_REMISE_EXCEPTIONNELLE = 'remise_exceptionnelle';

    /**
     * Sources possibles
     */
    const SOURCE_MIGRATION = 'migration';
    const SOURCE_MANUEL = 'manuel';
    const SOURCE_IMPORT = 'import';

    /**
     * Boot method pour générer un UUID et la référence automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->adjustment_id)) {
                $model->adjustment_id = (string) Str::uuid();
            }

            if (empty($model->reference)) {
                $model->reference = self::generateReference();
            }

            if (empty($model->date_ajustement)) {
                $model->date_ajustement = now();
            }
        });
    }

    /**
     * Génère une référence unique pour l'ajustement
     */
    public static function generateReference(): string
    {
        $year = date('Y');
        $prefix = "ADJ-{$year}-";

        $lastAdjustment = self::withTrashed()
            ->where('reference', 'like', $prefix . '%')
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastAdjustment) {
            $lastNumber = (int) substr($lastAdjustment->reference, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation : l'ajustement appartient à un client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Relation : l'ajustement a été créé par un utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Scope : filtrer par type d'ajustement
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope : filtrer par source
     */
    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Scope : filtrer par client
     */
    public function scopeByClient($query, string $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope : ajustements de migration
     */
    public function scopeMigration($query)
    {
        return $query->where('source', self::SOURCE_MIGRATION);
    }

    /**
     * Scope : dettes initiales
     */
    public function scopeDettesInitiales($query)
    {
        return $query->where('type', self::TYPE_DETTE_INITIALE);
    }

    /**
     * Scope : filtrer par période
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_ajustement', [$startDate, $endDate]);
    }

    /**
     * Accesseur : montant formaté
     */
    public function getFormattedMontantAttribute(): string
    {
        $sign = $this->montant >= 0 ? '+' : '';
        return $sign . number_format($this->montant, 2, ',', ' ') . ' FCFA';
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
     * Accesseur : libellé du type
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_DETTE_INITIALE => 'Dette initiale (Migration)',
            self::TYPE_AJUSTEMENT_CREDIT => 'Ajustement crédit (dette)',
            self::TYPE_AJUSTEMENT_DEBIT => 'Ajustement débit (réduction)',
            self::TYPE_CORRECTION => 'Correction',
            self::TYPE_REMISE_EXCEPTIONNELLE => 'Remise exceptionnelle',
            default => $this->type,
        };
    }

    /**
     * Accesseur : libellé de la source
     */
    public function getSourceLabelAttribute(): string
    {
        return match ($this->source) {
            self::SOURCE_MIGRATION => 'Migration système',
            self::SOURCE_MANUEL => 'Saisie manuelle',
            self::SOURCE_IMPORT => 'Import fichier',
            default => $this->source,
        };
    }

    /**
     * Vérifie si c'est un ajustement qui augmente la dette (montant négatif = diminue le solde)
     */
    public function isDebtIncreasing(): bool
    {
        return $this->montant < 0;
    }

    /**
     * Vérifie si c'est un ajustement qui diminue la dette (montant positif = augmente le solde)
     */
    public function isDebtDecreasing(): bool
    {
        return $this->montant > 0;
    }

    /**
     * Retourne le montant absolu de l'ajustement (toujours positif pour l'affichage)
     */
    public function getAbsoluteMontantAttribute(): float
    {
        return abs($this->montant);
    }

    /**
     * Retourne le montant absolu formaté
     */
    public function getFormattedAbsoluteMontantAttribute(): string
    {
        return number_format(abs($this->montant), 2, ',', ' ') . ' FCFA';
    }

    /**
     * Retourne les types disponibles
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_DETTE_INITIALE => 'Dette initiale (Migration)',
            self::TYPE_AJUSTEMENT_CREDIT => 'Ajustement crédit',
            self::TYPE_AJUSTEMENT_DEBIT => 'Ajustement débit',
            self::TYPE_CORRECTION => 'Correction',
            self::TYPE_REMISE_EXCEPTIONNELLE => 'Remise exceptionnelle',
        ];
    }

    /**
     * Retourne les sources disponibles
     */
    public static function getSources(): array
    {
        return [
            self::SOURCE_MIGRATION => 'Migration système',
            self::SOURCE_MANUEL => 'Saisie manuelle',
            self::SOURCE_IMPORT => 'Import fichier',
        ];
    }
}
