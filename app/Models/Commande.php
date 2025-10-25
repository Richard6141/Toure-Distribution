<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'commande_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_commande',
        'fournisseur_id',
        'chauffeur_id',
        'camion_id',
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
     * Boot du modèle
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
     * Génère un numéro de commande unique
     */
    public static function generateNumeroCommande(): string
    {
        $year = date('Y');
        $prefix = "CMD-{$year}-";

        $lastCommande = self::withTrashed()
            ->where('numero_commande', 'like', "{$prefix}%")
            ->orderBy('numero_commande', 'desc')
            ->first();

        if ($lastCommande) {
            $lastNumber = intval(substr($lastCommande->numero_commande, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // ========== RELATIONS ==========

    /**
     * Relation avec le fournisseur
     */
    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'fournisseur_id');
    }

    /**
     * Relation avec le chauffeur (livraison avec chauffeur propre)
     */
    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id', 'chauffeur_id');
    }

    /**
     * Relation avec le camion (livraison avec camion propre)
     */
    public function camion(): BelongsTo
    {
        return $this->belongsTo(Camion::class, 'camion_id', 'camion_id');
    }

    /**
     * Relation avec les détails de commande
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailCommande::class, 'commande_id', 'commande_id');
    }

    /**
     * Relation avec les mouvements de stock (répartitions)
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'commande_id', 'commande_id');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(PaiementCommande::class, 'commande_id', 'commande_id');
    }

    // ========== MÉTHODES POUR LA GESTION DE LA LIVRAISON ==========

    /**
     * Vérifie si la commande est livrée par le client (avec chauffeur et camion propres)
     */
    public function isLivraisonPropre(): bool
    {
        return !is_null($this->chauffeur_id) || !is_null($this->camion_id);
    }

    /**
     * Vérifie si la commande est livrée par le fournisseur
     */
    public function isLivraisonFournisseur(): bool
    {
        return is_null($this->chauffeur_id) && is_null($this->camion_id);
    }

    /**
     * Vérifie si un chauffeur est affecté à la commande
     */
    public function hasChauffeur(): bool
    {
        return !is_null($this->chauffeur_id);
    }

    /**
     * Vérifie si un camion est affecté à la commande
     */
    public function hasCamion(): bool
    {
        return !is_null($this->camion_id);
    }

    /**
     * Vérifie si la livraison est complète (chauffeur ET camion affectés)
     */
    public function hasCompleteLivraisonPropre(): bool
    {
        return $this->hasChauffeur() && $this->hasCamion();
    }

    /**
     * Affecte un chauffeur à la commande
     */
    public function assignChauffeur(string $chauffeurId): bool
    {
        $this->chauffeur_id = $chauffeurId;
        return $this->save();
    }

    /**
     * Affecte un camion à la commande
     */
    public function assignCamion(string $camionId): bool
    {
        $this->camion_id = $camionId;
        return $this->save();
    }

    /**
     * Retire le chauffeur de la commande
     */
    public function unassignChauffeur(): bool
    {
        $this->chauffeur_id = null;
        return $this->save();
    }

    /**
     * Retire le camion de la commande
     */
    public function unassignCamion(): bool
    {
        $this->camion_id = null;
        return $this->save();
    }

    /**
     * Affecte un chauffeur et un camion à la commande
     */
    public function assignLivraison(string $chauffeurId, string $camionId): bool
    {
        $this->chauffeur_id = $chauffeurId;
        $this->camion_id = $camionId;
        return $this->save();
    }

    /**
     * Retire le chauffeur et le camion de la commande
     */
    public function unassignLivraison(): bool
    {
        $this->chauffeur_id = null;
        $this->camion_id = null;
        return $this->save();
    }

    // ========== MÉTHODES POUR LA RÉPARTITION ==========

    /**
     * Vérifie si la commande peut être répartie dans les entrepôts
     * Seules les commandes livrées peuvent être réparties
     */
    public function canBeDistributed(): bool
    {
        return $this->status === 'livree';
    }

    /**
     * Calcule les quantités déjà réparties par produit
     * Ne compte que les mouvements validés
     */
    public function getQuantitesReparties(): array
    {
        $repartitions = $this->stockMovements()
            ->where('statut', 'validated')
            ->with('details')
            ->get();

        $quantitesParProduit = [];

        foreach ($repartitions as $repartition) {
            foreach ($repartition->details as $detail) {
                if (!isset($quantitesParProduit[$detail->product_id])) {
                    $quantitesParProduit[$detail->product_id] = 0;
                }
                $quantitesParProduit[$detail->product_id] += $detail->quantite;
            }
        }

        return $quantitesParProduit;
    }

    /**
     * Récupère les quantités restant à répartir par produit
     * Quantité restante = Quantité commandée - Quantité déjà répartie
     */
    public function getQuantitesRestantes(): array
    {
        $quantitesCommandees = [];
        foreach ($this->details as $detail) {
            $quantitesCommandees[$detail->product_id] = $detail->quantite;
        }

        $quantitesReparties = $this->getQuantitesReparties();

        $quantitesRestantes = [];
        foreach ($quantitesCommandees as $productId => $qteCommandee) {
            $qteRepartie = $quantitesReparties[$productId] ?? 0;
            $quantitesRestantes[$productId] = max(0, $qteCommandee - $qteRepartie);
        }

        return $quantitesRestantes;
    }

    /**
     * Vérifie si toute la commande a été répartie
     */
    public function isFullyDistributed(): bool
    {
        $quantitesRestantes = $this->getQuantitesRestantes();
        return array_sum($quantitesRestantes) === 0;
    }

    /**
     * Vérifie si des quantités peuvent encore être réparties
     */
    public function canDistributeMore(): bool
    {
        return !$this->isFullyDistributed();
    }

    // ========== MÉTHODES DE STATUT ==========

    public function isEnAttente(): bool
    {
        return $this->status === 'en_attente';
    }

    public function isValidee(): bool
    {
        return $this->status === 'validee';
    }

    public function isLivree(): bool
    {
        return $this->status === 'livree';
    }

    public function isAnnulee(): bool
    {
        return $this->status === 'annulee';
    }

    public function isEnRetard(): bool
    {
        if (in_array($this->status, ['livree', 'annulee'])) {
            return false;
        }
        return $this->date_livraison_prevue < now()->toDateString();
    }

    // ========== SCOPES ==========

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

    public function scopeEnRetard($query)
    {
        return $query->whereNotIn('status', ['livree', 'annulee'])
            ->where('date_livraison_prevue', '<', now()->toDateString());
    }

    public function scopeParFournisseur($query, $fournisseurId)
    {
        return $query->where('fournisseur_id', $fournisseurId);
    }

    /**
     * Scope pour les commandes livrées par le client (avec chauffeur/camion)
     */
    public function scopeLivraisonPropre($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('chauffeur_id')
                ->orWhereNotNull('camion_id');
        });
    }

    /**
     * Scope pour les commandes livrées par le fournisseur
     */
    public function scopeLivraisonFournisseur($query)
    {
        return $query->whereNull('chauffeur_id')
            ->whereNull('camion_id');
    }

    /**
     * Scope pour les commandes avec chauffeur spécifique
     */
    public function scopeParChauffeur($query, $chauffeurId)
    {
        return $query->where('chauffeur_id', $chauffeurId);
    }

    /**
     * Scope pour les commandes avec camion spécifique
     */
    public function scopeParCamion($query, $camionId)
    {
        return $query->where('camion_id', $camionId);
    }

    public function scopeParPeriodeAchat($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_achat', [$dateDebut, $dateFin]);
    }

    public function scopeMontantMin($query, $montant)
    {
        return $query->where('montant', '>=', $montant);
    }

    public function scopeMontantMax($query, $montant)
    {
        return $query->where('montant', '<=', $montant);
    }

    // ========== MÉTHODES DE CALCUL ==========

    public function calculerMontantTotal(): float
    {
        return $this->details()->sum('sous_total');
    }

    public function getMontantPayeAttribute(): float
    {
        return $this->paiements()->where('statut', 'valide')->sum('montant');
    }

    public function getMontantRestantAttribute(): float
    {
        return $this->montant - $this->montant_paye;
    }

    public function isTotalementPayee(): bool
    {
        return $this->montant_restant <= 0;
    }

    public function isPartiellementPayee(): bool
    {
        return $this->montant_paye > 0 && $this->montant_paye < $this->montant;
    }
}
