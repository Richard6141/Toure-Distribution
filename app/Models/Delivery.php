<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Delivery extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'delivery_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'vente_id',
        'client_id',
        'entrepot_id',
        'chauffeur_id',
        'camion_id',
        'date_livraison_prevue',
        'date_livraison_reelle',
        'heure_depart',
        'heure_arrivee',
        'statut',
        'adresse_livraison',
        'contact_livraison',
        'telephone_livraison',
        'note',
        'observation',
        'signature_client',
        'photos',
        'created_by',
    ];

    protected $casts = [
        'date_livraison_prevue' => 'datetime',
        'date_livraison_reelle' => 'datetime',
        'photos' => 'array',
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

        // Générer automatiquement la référence
        static::creating(function ($delivery) {
            if (empty($delivery->reference)) {
                $delivery->reference = self::generateReference();
            }
        });

        // Mettre à jour le statut de la vente lors de la création/mise à jour
        static::saved(function ($delivery) {
            $delivery->updateVenteStatus();
        });

        // Mettre à jour automatiquement le statut global basé sur les détails
        static::updating(function ($delivery) {
            if ($delivery->isDirty('statut')) {
                $delivery->syncDeliveryDetailsStatus();
            }
        });
    }

    /**
     * Génère une référence unique pour la livraison
     * Format: LIV-YYYY-0001
     */
    public static function generateReference(): string
    {
        $year = date('Y');
        $prefix = "LIV-{$year}-";

        $lastDelivery = self::withTrashed()
            ->where('reference', 'like', "{$prefix}%")
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastDelivery) {
            $lastNumber = intval(substr($lastDelivery->reference, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Met à jour le statut de la vente en fonction du statut de livraison
     */
    public function updateVenteStatus(): void
    {
        if (!$this->vente_id) {
            return;
        }

        $vente = Vente::find($this->vente_id);
        if (!$vente) {
            return;
        }

        // Logique de mise à jour du statut de vente
        switch ($this->statut) {
            case 'livree':
                $vente->status = 'livree';
                break;
            case 'livree_partiellement':
                $vente->status = 'partiellement_livree';
                break;
            case 'en_transit':
            case 'prete':
                if ($vente->status === 'validee') {
                    // Ne change que si la vente est validée
                    $vente->status = 'en_cours_livraison';
                }
                break;
        }

        $vente->saveQuietly(); // Sauvegarder sans déclencher les événements
    }

    /**
     * Synchronise le statut des détails avec le statut global
     */
    public function syncDeliveryDetailsStatus(): void
    {
        if ($this->statut === 'annulee') {
            $this->deliveryDetails()->update(['statut' => 'annule']);
        } elseif ($this->statut === 'livree') {
            $this->deliveryDetails()->update(['statut' => 'livre']);
        }
    }

    /**
     * Démarre la livraison (passage en transit)
     */
    public function startDelivery(): bool
    {
        if ($this->statut !== 'prete') {
            return false;
        }

        DB::beginTransaction();
        try {
            $this->statut = 'en_transit';
            $this->heure_depart = now()->format('H:i:s');
            $this->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Termine la livraison
     */
    public function completeDelivery(array $data = []): bool
    {
        DB::beginTransaction();
        try {
            $this->statut = 'livree';
            $this->date_livraison_reelle = now();
            $this->heure_arrivee = now()->format('H:i:s');

            if (isset($data['observation'])) {
                $this->observation = $data['observation'];
            }

            if (isset($data['signature_client'])) {
                $this->signature_client = $data['signature_client'];
            }

            if (isset($data['photos'])) {
                $this->photos = $data['photos'];
            }

            $this->save();

            // Mettre à jour tous les détails comme livrés
            $this->deliveryDetails()->update([
                'statut' => 'livre',
                'quantite_livree' => DB::raw('quantite_preparee')
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Annule la livraison
     */
    public function cancel(string $raison = null): bool
    {
        DB::beginTransaction();
        try {
            $this->statut = 'annulee';
            if ($raison) {
                $this->note = ($this->note ? $this->note . "\n" : '') . "Annulation: {$raison}";
            }
            $this->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Calcule le taux de complétion de la livraison
     */
    public function getCompletionRateAttribute(): float
    {
        $totalCommande = $this->deliveryDetails->sum('quantite_commandee');
        $totalLivre = $this->deliveryDetails->sum('quantite_livree');

        if ($totalCommande == 0) {
            return 0;
        }

        return round(($totalLivre / $totalCommande) * 100, 2);
    }

    /**
     * Vérifie si la livraison est en retard
     */
    public function isLate(): bool
    {
        if (!$this->date_livraison_prevue) {
            return false;
        }

        if (in_array($this->statut, ['livree', 'annulee'])) {
            return false;
        }

        return now()->isAfter($this->date_livraison_prevue);
    }

    /**
     * Vérifie si tous les produits sont prêts
     */
    public function allProductsReady(): bool
    {
        return $this->deliveryDetails()
            ->whereNotIn('statut', ['pret', 'livre'])
            ->count() === 0;
    }

    /**
     * Relations
     */
    public function vente(): BelongsTo
    {
        return $this->belongsTo(Vente::class, 'vente_id', 'vente_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function entrepot(): BelongsTo
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_id', 'entrepot_id');
    }

    public function chauffeur(): BelongsTo
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id', 'chauffeur_id');
    }

    public function camion(): BelongsTo
    {
        return $this->belongsTo(Camion::class, 'camion_id', 'camion_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function deliveryDetails(): HasMany
    {
        return $this->hasMany(DeliveryDetail::class, 'delivery_id', 'delivery_id');
    }

    /**
     * Scopes
     */
    public function scopeEnPreparation($query)
    {
        return $query->where('statut', 'en_preparation');
    }

    public function scopePrete($query)
    {
        return $query->where('statut', 'prete');
    }

    public function scopeEnTransit($query)
    {
        return $query->where('statut', 'en_transit');
    }

    public function scopeLivree($query)
    {
        return $query->where('statut', 'livree');
    }

    public function scopeEnRetard($query)
    {
        return $query->where('date_livraison_prevue', '<', now())
            ->whereNotIn('statut', ['livree', 'annulee']);
    }

    public function scopeParChauffeur($query, $chauffeurId)
    {
        return $query->where('chauffeur_id', $chauffeurId);
    }

    public function scopeParPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_livraison_prevue', [$dateDebut, $dateFin]);
    }

    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_livraison_prevue', today());
    }
}
