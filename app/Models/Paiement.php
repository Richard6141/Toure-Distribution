<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Paiement extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'paiements';

    protected $primaryKey = 'paiement_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reference',
        'facture_id',
        'client_id',
        'payment_method_id',
        'amount',
        'payment_date',
        'note',
        'statut',
        'user_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Génération automatique d'une référence unique
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paiement) {
            $prefix = 'PAY-' . date('Y') . '-';
            $last = self::orderBy('created_at', 'desc')->first();
            $next = $last ? ((int) substr($last->reference, -5)) + 1 : 1;
            $paiement->reference = $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
        });
    }

    /** Relation avec la facture */
    public function facture()
    {
        return $this->belongsTo(Facture::class, 'facture_id', 'facture_id');
    }

    /** Relation avec le client */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /** Relation avec le mode de paiement */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'payment_method_id');
    }

    /** Relation avec l'utilisateur qui a enregistré le paiement */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
