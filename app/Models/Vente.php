<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Vente extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = 'vente_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_vente',
        'client_id',
        'entrepot_id',
        'date_vente',
        'montant_ht',
        'montant_taxe',
        'montant_total',
        'remise',
        'montant_net',
        'status',
        'statut_paiement',
        'note',
        'stock_movement_id',
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
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vente) {
            if (empty($vente->numero_vente)) {
                $vente->numero_vente = self::generateNumeroVente();
            }
        });

        // Après création d'une vente validée, créer le mouvement de stock
        static::created(function ($vente) {
            if ($vente->status === 'validee' && $vente->entrepot_id) {
                $vente->createStockMovement();
            }
        });

        // Lors de la mise à jour du statut
        static::updating(function ($vente) {
            // Si le statut passe à "validee" et qu'il n'y a pas encore de mouvement
            if (
                $vente->isDirty('status') &&
                $vente->status === 'validee' &&
                !$vente->stock_movement_id &&
                $vente->entrepot_id
            ) {
                $vente->createStockMovement();
            }

            // Si le statut passe à "annulee" et qu'il y a un mouvement validé
            if (
                $vente->isDirty('status') &&
                $vente->status === 'annulee' &&
                $vente->stock_movement_id
            ) {
                $vente->cancelStockMovement();
            }
        });

        // Avant suppression, annuler le mouvement de stock si nécessaire
        static::deleting(function ($vente) {
            if ($vente->stock_movement_id) {
                $vente->cancelStockMovement();
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
     * Crée un mouvement de stock pour cette vente
     */
    public function createStockMovement(): void
    {
        DB::beginTransaction();
        try {
            // Vérifier que la vente a des détails
            if ($this->detailVentes->isEmpty()) {
                throw new \Exception("Impossible de créer un mouvement de stock sans détails de vente");
            }

            // Vérifier que l'entrepôt est défini
            if (!$this->entrepot_id) {
                throw new \Exception("L'entrepôt source doit être défini pour créer un mouvement de stock");
            }

            // Générer la référence du mouvement
            $reference = $this->generateStockMovementReference();

            // Créer le mouvement de stock
            $stockMovement = StockMovement::create([
                'stock_movement_id' => (string) Str::uuid(),
                'reference' => $reference,
                'movement_type' => 'sortie',
                'entrepot_from_id' => $this->entrepot_id,
                'client_id' => $this->client_id,
                'statut' => 'pending',
                'note' => "Mouvement automatique pour la vente {$this->numero_vente}",
                'user_id' => auth()->user()->user_id ?? null,
            ]);

            // Créer les détails du mouvement
            foreach ($this->detailVentes as $detail) {
                $stockMovement->details()->create([
                    'stock_movement_detail_id' => (string) Str::uuid(),
                    'product_id' => $detail->product_id,
                    'quantite' => $detail->quantite,
                ]);
            }

            // Valider immédiatement le mouvement (met à jour les stocks)
            $stockMovement->validate();

            // Lier le mouvement à la vente
            $this->stock_movement_id = $stockMovement->stock_movement_id;
            $this->saveQuietly(); // Sauvegarder sans déclencher les événements

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Annule le mouvement de stock associé
     */
    public function cancelStockMovement(): void
    {
        if (!$this->stock_movement_id) {
            return;
        }

        DB::beginTransaction();
        try {
            $stockMovement = StockMovement::find($this->stock_movement_id);

            if ($stockMovement && $stockMovement->statut === 'validated') {
                // Annuler le mouvement (restaure les stocks)
                $stockMovement->statut = 'cancelled';
                $stockMovement->note .= " | Annulé suite à l'annulation/suppression de la vente {$this->numero_vente}";
                $stockMovement->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Génère une référence unique pour le mouvement de stock
     */
    private function generateStockMovementReference(): string
    {
        $year = date('Y');
        $prefix = "MV-{$year}-";

        $lastMovement = StockMovement::where('reference', 'like', "{$prefix}%")
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastMovement) {
            $lastNumber = (int) substr($lastMovement->reference, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Relations
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function entrepot(): BelongsTo
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_id', 'entrepot_id');
    }

    public function detailVentes(): HasMany
    {
        return $this->hasMany(DetailVente::class, 'vente_id', 'vente_id');
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(PaiementVente::class, 'vente_id', 'vente_id');
    }

    public function stockMovement(): BelongsTo
    {
        return $this->belongsTo(StockMovement::class, 'stock_movement_id', 'stock_movement_id');
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
