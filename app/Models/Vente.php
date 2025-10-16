<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vente extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'vente_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_vente',
        'client_id',
        'date_vente',
        'montant_ht',
        'montant_taxe',
        'montant_total',
        'remise',
        'montant_net',
        'status',
        'statut_paiement',
        'note',
    ];

    protected $casts = [
        'date_vente' => 'datetime',
        'montant_ht' => 'decimal:2',
        'montant_taxe' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'remise' => 'decimal:2',
        'montant_net' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot du modèle pour générer automatiquement le numéro de vente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vente) {
            if (empty($vente->numero_vente)) {
                $vente->numero_vente = self::generateNumeroVente();
            }
        });
    }

    /**
     * Génère automatiquement un numéro de vente unique
     * Format: VTE-YYYY-0001
     */
    public static function generateNumeroVente(): string
    {
        $year = date('Y');
        $prefix = "VTE-{$year}-";

        $lastVente = self::withTrashed()
            ->where('numero_vente', 'like', "{$prefix}%")
            ->orderBy('numero_vente', 'desc')
            ->first();

        if ($lastVente) {
            $lastNumber = intval(substr($lastVente->numero_vente, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation avec le client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Relation avec les détails de vente
     */
    public function detailVentes(): HasMany
    {
        return $this->hasMany(DetailVente::class, 'vente_id', 'vente_id');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(PaiementVente::class, 'vente_id', 'vente_id');
    }

    /**
     * Calcule le montant total payé
     */
    public function getMontantPayeAttribute(): float
    {
        return $this->paiements()->where('statut', 'valide')->sum('montant');
    }

    /**
     * Calcule le montant restant à payer
     */
    public function getMontantRestantAttribute(): float
    {
        return $this->montant_net - $this->montant_paye;
    }

    /**
     * Vérifie si la vente est totalement payée
     */
    public function isTotalementPayee(): bool
    {
        return $this->montant_restant <= 0;
    }

    /**
     * Vérifie si la vente est partiellement payée
     */
    public function isPartiellementPayee(): bool
    {
        return $this->montant_paye > 0 && $this->montant_paye < $this->montant_net;
    }

    /**
     * Vérifie si la vente est validée
     */
    public function isValidee(): bool
    {
        return $this->status === 'validee';
    }

    /**
     * Vérifie si la vente est livrée
     */
    public function isLivree(): bool
    {
        return $this->status === 'livree';
    }

    /**
     * Vérifie si la vente est annulée
     */
    public function isAnnulee(): bool
    {
        return $this->status === 'annulee';
    }

    /**
     * Met à jour le statut de paiement
     */
    public function updateStatutPaiement(): void
    {
        if ($this->isTotalementPayee()) {
            $this->statut_paiement = 'paye_totalement';
        } elseif ($this->isPartiellementPayee()) {
            $this->statut_paiement = 'paye_partiellement';
        } else {
            $this->statut_paiement = 'non_paye';
        }
        $this->save();
    }

    /**
     * Scopes
     */
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }

    public function scopeValidees($query)
    {
        return $query->where('status', 'validee');
    }

    public function scopeLivrees($query)
    {
        return $query->where('status', 'livree');
    }

    public function scopeParClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeParPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
    }

    public function scopeNonPayees($query)
    {
        return $query->where('statut_paiement', 'non_paye');
    }

    public function scopePayeesPartiellement($query)
    {
        return $query->where('statut_paiement', 'paye_partiellement');
    }
}
