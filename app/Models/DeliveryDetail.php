<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'delivery_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'delivery_id',
        'product_id',
        'detail_vente_id',
        'quantite_commandee',
        'quantite_preparee',
        'quantite_livree',
        'quantite_retournee',
        'statut',
        'note',
        'raison_ecart',
        'poids',
        'volume',
    ];

    protected $casts = [
        'quantite_commandee' => 'integer',
        'quantite_preparee' => 'integer',
        'quantite_livree' => 'integer',
        'quantite_retournee' => 'integer',
        'poids' => 'decimal:2',
        'volume' => 'decimal:2',
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

        // Mettre à jour automatiquement le statut en fonction des quantités
        static::saving(function ($detail) {
            $detail->updateStatutAutomatique();
        });

        // Après sauvegarde, vérifier si on doit mettre à jour le statut global de la livraison
        static::saved(function ($detail) {
            $detail->updateDeliveryStatus();
        });
    }

    /**
     * Met à jour automatiquement le statut en fonction des quantités
     */
    protected function updateStatutAutomatique(): void
    {
        // Si tout est livré
        if ($this->quantite_livree > 0 && $this->quantite_livree >= $this->quantite_preparee) {
            $this->statut = 'livre';
        }
        // Si partiellement livré
        elseif ($this->quantite_livree > 0 && $this->quantite_livree < $this->quantite_preparee) {
            $this->statut = 'partiellement_livre';
        }
        // Si tout est retourné
        elseif ($this->quantite_retournee > 0 && $this->quantite_retournee >= $this->quantite_preparee) {
            $this->statut = 'retourne';
        }
        // Si préparé
        elseif ($this->quantite_preparee > 0 && $this->quantite_preparee >= $this->quantite_commandee) {
            if ($this->statut === 'en_attente' || $this->statut === 'en_preparation') {
                $this->statut = 'pret';
            }
        }
        // Si en préparation
        elseif ($this->quantite_preparee > 0 && $this->quantite_preparee < $this->quantite_commandee) {
            if ($this->statut === 'en_attente') {
                $this->statut = 'en_preparation';
            }
        }
    }

    /**
     * Met à jour le statut global de la livraison
     */
    public function updateDeliveryStatus(): void
    {
        $delivery = $this->delivery;
        if (!$delivery) {
            return;
        }

        // Récupérer tous les détails
        $details = $delivery->deliveryDetails;

        // Vérifier si tous sont livrés
        $allLivres = $details->every(function ($detail) {
            return $detail->statut === 'livre';
        });

        // Vérifier si au moins un est livré
        $someLivres = $details->contains(function ($detail) {
            return $detail->statut === 'livre' || $detail->statut === 'partiellement_livre';
        });

        // Vérifier si tous sont prêts
        $allPrets = $details->every(function ($detail) {
            return $detail->statut === 'pret';
        });

        // Mettre à jour le statut de la livraison
        if ($allLivres) {
            $delivery->statut = 'livree';
            $delivery->saveQuietly();
        } elseif ($someLivres && $delivery->statut === 'en_transit') {
            $delivery->statut = 'livree_partiellement';
            $delivery->saveQuietly();
        } elseif ($allPrets && $delivery->statut === 'en_preparation') {
            $delivery->statut = 'prete';
            $delivery->saveQuietly();
        }
    }

    /**
     * Prépare une quantité pour ce produit
     */
    public function preparer(int $quantite): bool
    {
        if ($quantite <= 0 || $quantite > $this->quantite_commandee) {
            return false;
        }

        $this->quantite_preparee = $quantite;
        $this->save();

        return true;
    }

    /**
     * Livre une quantité pour ce produit
     */
    public function livrer(int $quantite, string $observation = null): bool
    {
        if ($quantite <= 0 || $quantite > $this->quantite_preparee) {
            return false;
        }

        $this->quantite_livree = $quantite;

        if ($quantite < $this->quantite_preparee && $observation) {
            $this->raison_ecart = $observation;
        }

        $this->save();

        return true;
    }

    /**
     * Retourne une quantité pour ce produit
     */
    public function retourner(int $quantite, string $raison): bool
    {
        if ($quantite <= 0 || $quantite > $this->quantite_preparee) {
            return false;
        }

        $this->quantite_retournee = $quantite;
        $this->raison_ecart = $raison;
        $this->save();

        return true;
    }

    /**
     * Calcule le taux de livraison pour ce produit
     */
    public function getTauxLivraisonAttribute(): float
    {
        if ($this->quantite_commandee == 0) {
            return 0;
        }

        return round(($this->quantite_livree / $this->quantite_commandee) * 100, 2);
    }

    /**
     * Vérifie si le produit a un écart
     */
    public function hasEcart(): bool
    {
        return $this->quantite_livree !== $this->quantite_commandee;
    }

    /**
     * Vérifie si le produit est complètement livré
     */
    public function isFullyDelivered(): bool
    {
        return $this->quantite_livree >= $this->quantite_commandee;
    }

    /**
     * Vérifie si le produit est en rupture
     */
    public function isOutOfStock(): bool
    {
        return $this->statut === 'manquant';
    }

    /**
     * Relations
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'delivery_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function detailVente(): BelongsTo
    {
        return $this->belongsTo(DetailVente::class, 'detail_vente_id', 'detail_vente_id');
    }

    /**
     * Scopes
     */
    public function scopePret($query)
    {
        return $query->where('statut', 'pret');
    }

    public function scopeLivre($query)
    {
        return $query->where('statut', 'livre');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAvecEcart($query)
    {
        return $query->whereColumn('quantite_livree', '!=', 'quantite_commandee');
    }
}
