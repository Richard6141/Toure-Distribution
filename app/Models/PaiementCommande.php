<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaiementCommande extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Le nom de la table
     */
    protected $table = 'paiement_commandes';

    /**
     * Le nom de la clé primaire
     */
    protected $primaryKey = 'paiement_commande_id';

    /**
     * Indique si la clé primaire est auto-incrémentée
     */
    public $incrementing = false;

    /**
     * Le type de la clé primaire
     */
    protected $keyType = 'string';

    /**
     * Les attributs assignables en masse
     */
    protected $fillable = [
        'reference_paiement',
        'commande_id',
        'montant',
        'mode_paiement',
        'statut',
        'date_paiement',
        'numero_transaction',
        'numero_cheque',
        'banque',
        'note',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot du modèle pour générer automatiquement la référence de paiement
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paiement) {
            if (empty($paiement->reference_paiement)) {
                $paiement->reference_paiement = self::generateReferencePaiement();
            }
        });
    }

    /**
     * Génère automatiquement une référence de paiement unique
     * Format: PAY-YYYY-0001
     */
    public static function generateReferencePaiement(): string
    {
        $year = date('Y');
        $prefix = "PAY-{$year}-";

        // Récupérer la dernière référence de paiement de l'année en cours
        $lastPaiement = self::withTrashed()
            ->where('reference_paiement', 'like', "{$prefix}%")
            ->orderBy('reference_paiement', 'desc')
            ->first();

        if ($lastPaiement) {
            // Extraire le numéro et incrémenter
            $lastNumber = intval(substr($lastPaiement->reference_paiement, -4));
            $newNumber = $lastNumber + 1;
        } else {
            // Premier numéro de l'année
            $newNumber = 1;
        }

        // Formater avec des zéros à gauche (4 chiffres)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relation avec la commande
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'commande_id');
    }

    /**
     * Vérifie si le paiement est en attente
     */
    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    /**
     * Vérifie si le paiement est validé
     */
    public function isValide(): bool
    {
        return $this->statut === 'valide';
    }

    /**
     * Vérifie si le paiement est refusé
     */
    public function isRefuse(): bool
    {
        return $this->statut === 'refuse';
    }

    /**
     * Vérifie si le paiement est annulé
     */
    public function isAnnule(): bool
    {
        return $this->statut === 'annule';
    }

    /**
     * Vérifie si le paiement est électronique
     */
    public function isElectronique(): bool
    {
        return in_array($this->mode_paiement, ['carte_bancaire', 'mobile_money', 'virement']);
    }

    /**
     * Scope pour obtenir uniquement les paiements validés
     */
    public function scopeValides($query)
    {
        return $query->where('statut', 'valide');
    }

    /**
     * Scope pour obtenir les paiements en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour filtrer par commande
     */
    public function scopeParCommande($query, $commandeId)
    {
        return $query->where('commande_id', $commandeId);
    }

    /**
     * Scope pour filtrer par mode de paiement
     */
    public function scopeParMode($query, $mode)
    {
        return $query->where('mode_paiement', $mode);
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopeParPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_paiement', [$dateDebut, $dateFin]);
    }
}
