<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'stock_movement_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'movement_type',
        'entrepot_from_id',
        'entrepot_to_id',
        'fournisseur_id',
        'commande_id',
        'client_id',
        'statut',
        'note',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_movement_id)) {
                $model->stock_movement_id = (string) Str::uuid();
            }
        });

        static::created(function ($movement) {
            if ($movement->statut === 'validated') {
                $movement->updateStocks();
            }
        });

        static::updated(function ($movement) {
            if ($movement->isDirty('statut') && $movement->statut === 'validated') {
                $movement->updateStocks();
            }

            if ($movement->isDirty('statut') && $movement->getOriginal('statut') === 'validated' && $movement->statut !== 'validated') {
                $movement->reverseStocks();
            }
        });

        static::deleting(function ($movement) {
            if ($movement->statut === 'validated') {
                $movement->reverseStocks();
            }
        });
    }

    /**
     * Met à jour les stocks avec création automatique si nécessaire
     */
    public function updateStocks()
    {
        foreach ($this->details as $detail) {
            // Transfert entre entrepôts
            if ($this->entrepot_from_id && $this->entrepot_to_id) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    -$detail->quantite
                );

                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    $detail->quantite
                );
            }
            // Réception fournisseur/commande (entrée)
            elseif ($this->entrepot_to_id && ($this->fournisseur_id || $this->commande_id)) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    $detail->quantite
                );
            }
            // Sortie client
            elseif ($this->client_id && $this->entrepot_from_id) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    -$detail->quantite
                );
            }
        }
    }

    /**
     * Annule les mouvements de stock
     */
    public function reverseStocks()
    {
        foreach ($this->details as $detail) {
            if ($this->entrepot_from_id && $this->entrepot_to_id) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    $detail->quantite
                );

                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    -$detail->quantite
                );
            } elseif ($this->entrepot_to_id && ($this->fournisseur_id || $this->commande_id)) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    -$detail->quantite
                );
            } elseif ($this->client_id && $this->entrepot_from_id) {
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    $detail->quantite
                );
            }
        }
    }

    /**
     * Met à jour ou crée un enregistrement de stock
     * CRÉATION AUTOMATIQUE si le stock n'existe pas pour ce produit dans cet entrepôt
     */
    private function updateOrCreateStock($productId, $entrepotId, $quantityChange)
    {
        $stock = Stock::where('product_id', $productId)
            ->where('entrepot_id', $entrepotId)
            ->first();

        if ($stock) {
            // Mise à jour du stock existant
            $stock->quantite += $quantityChange;
            $stock->save();
        } else {
            // CRÉATION AUTOMATIQUE d'un nouveau stock
            Stock::create([
                'stock_id' => (string) Str::uuid(),
                'product_id' => $productId,
                'entrepot_id' => $entrepotId,
                'quantite' => max(0, $quantityChange),
                'reserved_quantity' => 0
            ]);
        }
    }

    /**
     * Valide le mouvement et met à jour les stocks
     */
    public function validate()
    {
        DB::beginTransaction();
        try {
            // Vérifier la disponibilité du stock pour les sorties
            if ($this->entrepot_from_id) {
                foreach ($this->details as $detail) {
                    $stock = Stock::where('product_id', $detail->product_id)
                        ->where('entrepot_id', $this->entrepot_from_id)
                        ->first();

                    $availableQuantity = $stock ? ($stock->quantite - $stock->reserved_quantity) : 0;

                    if ($availableQuantity < $detail->quantite) {
                        throw new \Exception(
                            "Stock insuffisant pour le produit {$detail->product->name}. " .
                                "Disponible: {$availableQuantity}, Demandé: {$detail->quantite}"
                        );
                    }
                }
            }

            $this->statut = 'validated';
            $this->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== RELATIONS ==========

    public function entrepotFrom()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_from_id', 'entrepot_id');
    }

    public function entrepotTo()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_to_id', 'entrepot_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(StockMovementDetail::class, 'stock_movement_id', 'stock_movement_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'fournisseur_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id', 'commande_id');
    }
}
