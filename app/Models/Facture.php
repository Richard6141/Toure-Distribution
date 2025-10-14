<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'factures';

    protected $primaryKey = 'facture_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'facture_number',
        'reference',
        'client_id',
        'facture_date',
        'due_date',
        'montant_ht',
        'taxe_rate',
        'transport_cost',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'statut',
        'delivery_adresse',
        'note',
        'user_id',
    ];

    protected $casts = [
        'facture_date' => 'datetime',
        'due_date' => 'date',
        'montant_ht' => 'decimal:2',
        'taxe_rate' => 'decimal:2',
        'transport_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Relation avec les détails de la facture
     */
    public function details()
    {
        return $this->hasMany(FactureDetail::class, 'facture_id', 'facture_id');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'facture_id', 'facture_id');
    }

    /**
     * Relation avec l'utilisateur qui a créé la facture
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Génère automatiquement le numéro de facture avant la création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facture) {
            // Format : FACT-2025-00001
            $prefix = 'FACT-' . date('Y') . '-';
            $lastFacture = self::withTrashed()
                ->orderBy('created_at', 'desc')
                ->first();

            $nextNumber = $lastFacture
                ? ((int) substr($lastFacture->facture_number, -5)) + 1
                : 1;

            $facture->facture_number = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Si la date n'est pas précisée, on la met à la date du jour
            if (!$facture->facture_date) {
                $facture->facture_date = now();
            }
        });
    }
}
