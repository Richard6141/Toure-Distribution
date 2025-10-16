<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaiementVente extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'paiement_vente_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference_paiement',
        'vente_id',
        'montant',
        'mode_paiement',
        'statut',
        'date_paiement',
        'numero_transaction',
        'numero_cheque',
        'banque',
        'note',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paiement) {
            if (empty($paiement->reference_paiement)) {
                $paiement->reference_paiement = self::generateReferencePaiement();
            }
        });

        // Mettre à jour le statut de paiement de la vente après création/modification/suppression
        static::saved(function ($paiement) {
            $paiement->vente->updateStatutPaiement();
        });

        static::deleted(function ($paiement) {
            $paiement->vente->updateStatutPaiement();
        });
    }

    /**
     * Génère une référence de paiement unique
     * Format: PAYV-YYYY-0001
     */
    public static function generateReferencePaiement(): string
    {
        $year = date('Y');
        $prefix = "PAYV-{$year}-";

        $lastPaiement = self::withTrashed()
            ->where('reference_paiement', 'like', "{$prefix}%")
            ->orderBy('reference_paiement', 'desc')
            ->first();

        if ($lastPaiement) {
            $lastNumber = intval(substr($lastPaiement->reference_paiement, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation avec la vente
     */
    public function vente(): BelongsTo
    {
        return $this->belongsTo(Vente::class, 'vente_id', 'vente_id');
    }

    /**
     * Vérifie si le paiement est validé
     */
    public function isValide(): bool
    {
        return $this->statut === 'valide';
    }

    /**
     * Scopes
     */
    public function scopeValides($query)
    {
        return $query->where('statut', 'valide');
    }

    public function scopeParVente($query, $venteId)
    {
        return $query->where('vente_id', $venteId);
    }
}
