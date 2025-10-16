<?php

namespace App\Models;

use Fournisseur;
use App\Models\DetailCommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'commande_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_commande',
        'fournisseur_id',
        'date_achat',
        'date_livraison_prevue',
        'date_livraison_effective',
        'montant',
        'status',
        'note',
    ];

    protected $casts = [
        'date_achat' => 'date',
        'date_livraison_prevue' => 'date',
        'date_livraison_effective' => 'date',
        'montant' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot du modèle pour générer automatiquement le numéro de commande
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            if (empty($commande->numero_commande)) {
                $commande->numero_commande = self::generateNumeroCommande();
            }
        });
    }

    /**
     * Génère automatiquement un numéro de commande unique
     * Format: CMD-YYYY-0001
     */
    public static function generateNumeroCommande(): string
    {
        $year = date('Y');
        $prefix = "CMD-{$year}-";

        // Récupérer le dernier numéro de commande de l'année en cours
        $lastCommande = self::withTrashed()
            ->where('numero_commande', 'like', "{$prefix}%")
            ->orderBy('numero_commande', 'desc')
            ->first();

        if ($lastCommande) {
            // Extraire le numéro et incrémenter
            $lastNumber = intval(substr($lastCommande->numero_commande, -4));
            $newNumber = $lastNumber + 1;
        } else {
            // Premier numéro de l'année
            $newNumber = 1;
        }

        // Formater avec des zéros à gauche (4 chiffres)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation avec le fournisseur
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'fournisseur_id');
    }

    /**
     * Vérifie si la commande est en attente
     */
    public function isEnAttente(): bool
    {
        return $this->status === 'en_attente';
    }

    /**
     * Vérifie si la commande est validée
     */
    public function isValidee(): bool
    {
        return $this->status === 'validee';
    }

    /**
     * Vérifie si la commande est livrée
     */
    public function isLivree(): bool
    {
        return $this->status === 'livree';
    }

    /**
     * Vérifie si la commande est annulée
     */
    public function isAnnulee(): bool
    {
        return $this->status === 'annulee';
    }

    /**
     * Vérifie si la livraison est en retard
     */
    public function isEnRetard(): bool
    {
        if (in_array($this->status, ['livree', 'annulee'])) {
            return false;
        }

        return $this->date_livraison_prevue < now()->toDateString();
    }

    /**
     * Scope pour obtenir uniquement les commandes en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }

    /**
     * Scope pour obtenir les commandes validées
     */
    public function scopeValidees($query)
    {
        return $query->where('status', 'validee');
    }

    /**
     * Scope pour obtenir les commandes livrées
     */
    public function scopeLivrees($query)
    {
        return $query->where('status', 'livree');
    }

    /**
     * Scope pour obtenir les commandes en retard
     */
    public function scopeEnRetard($query)
    {
        return $query->whereNotIn('status', ['livree', 'annulee'])
            ->where('date_livraison_prevue', '<', now()->toDateString());
    }

    /**
     * Scope pour filtrer par fournisseur
     */
    public function scopeParFournisseur($query, $fournisseurId)
    {
        return $query->where('fournisseur_id', $fournisseurId);
    }

    /**
     * Scope pour filtrer par période de dates d'achat
     */
    public function scopeParPeriodeAchat($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_achat', [$dateDebut, $dateFin]);
    }

    /**
     * Scope pour filtrer par montant minimum
     */
    public function scopeMontantMin($query, $montant)
    {
        return $query->where('montant', '>=', $montant);
    }

    /**
     * Scope pour filtrer par montant maximum
     */
    public function scopeMontantMax($query, $montant)
    {
        return $query->where('montant', '<=', $montant);
    }

    /**
     * Relation avec les détails de commande
     */
    public function details()
    {
        return $this->hasMany(DetailCommande::class, 'commande_id', 'commande_id');
    }

    /**
     * Calcule le montant total de la commande basé sur les détails
     */
    public function calculerMontantTotal(): float
    {
        return $this->details()->sum('sous_total');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(PaiementCommande::class, 'commande_id', 'commande_id');
    }

    /**
     * Calcule le montant total payé
     */
    public function getMontantPayeAttribute(): float
    {
        return $this->paiements()->valides()->sum('montant');
    }

    /**
     * Calcule le montant restant à payer
     */
    public function getMontantRestantAttribute(): float
    {
        return $this->montant - $this->montant_paye;
    }

    /**
     * Vérifie si la commande est totalement payée
     */
    public function isTotalementPayee(): bool
    {
        return $this->montant_restant <= 0;
    }

    /**
     * Vérifie si la commande est partiellement payée
     */
    public function isPartiellementPayee(): bool
    {
        return $this->montant_paye > 0 && $this->montant_paye < $this->montant;
    }
}
