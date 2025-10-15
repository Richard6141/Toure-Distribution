<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'client_id',
        'statut',
        'note',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->stock_movement_id)) {
                $model->stock_movement_id = (string) Str::uuid();
            }
        });

        // Événement après création : mise à jour des stocks quand le statut est 'validated'
        static::created(function ($movement) {
            if ($movement->statut === 'validated') {
                $movement->updateStocks();
            }
        });

        // Événement après mise à jour : gérer le changement de statut
        static::updated(function ($movement) {
            // Si le statut passe à 'validated', mettre à jour les stocks
            if ($movement->isDirty('statut') && $movement->statut === 'validated') {
                $movement->updateStocks();
            }

            // Si le statut passe de 'validated' à autre chose, annuler les mouvements
            if ($movement->isDirty('statut') && $movement->getOriginal('statut') === 'validated' && $movement->statut !== 'validated') {
                $movement->reverseStocks();
            }
        });

        // Événement avant suppression : annuler les mouvements de stock si validé
        static::deleting(function ($movement) {
            if ($movement->statut === 'validated') {
                $movement->reverseStocks();
            }
        });
    }

    /**
     * Met à jour les stocks en fonction du type de mouvement
     */
    public function updateStocks()
    {
        foreach ($this->details as $detail) {
            // Transfert entre entrepôts
            if ($this->entrepot_from_id && $this->entrepot_to_id) {
                // Diminuer le stock de l'entrepôt source
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    -$detail->quantite
                );

                // Augmenter le stock de l'entrepôt destination
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    $detail->quantite
                );
            }
            // Réception fournisseur (entrée)
            elseif ($this->fournisseur_id && $this->entrepot_to_id) {
                // Augmenter le stock de l'entrepôt destination
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    $detail->quantite
                );
            }
            // Sortie client
            elseif ($this->client_id && $this->entrepot_from_id) {
                // Diminuer le stock de l'entrepôt source
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    -$detail->quantite
                );
            }
        }
    }

    /**
     * Annule les mouvements de stock (inverse de updateStocks)
     */
    public function reverseStocks()
    {
        foreach ($this->details as $detail) {
            // Transfert entre entrepôts
            if ($this->entrepot_from_id && $this->entrepot_to_id) {
                // Augmenter le stock de l'entrepôt source (inverse)
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_from_id,
                    $detail->quantite
                );

                // Diminuer le stock de l'entrepôt destination (inverse)
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    -$detail->quantite
                );
            }
            // Réception fournisseur (entrée)
            elseif ($this->fournisseur_id && $this->entrepot_to_id) {
                // Diminuer le stock de l'entrepôt destination (inverse)
                $this->updateOrCreateStock(
                    $detail->product_id,
                    $this->entrepot_to_id,
                    -$detail->quantite
                );
            }
            // Sortie client
            elseif ($this->client_id && $this->entrepot_from_id) {
                // Augmenter le stock de l'entrepôt source (inverse)
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
            // Création d'un nouveau stock
            Stock::create([
                'stock_id' => (string) Str::uuid(),
                'product_id' => $productId,
                'entrepot_id' => $entrepotId,
                'quantite' => max(0, $quantityChange), // Ne pas créer de stock négatif
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

    // Relations
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
}
