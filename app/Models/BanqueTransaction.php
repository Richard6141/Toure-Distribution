<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanqueTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'banque_transactions';
    protected $primaryKey = 'banque_transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'banque_account_id',
        'transaction_number',
        'transaction_date',
        'transaction_type',
        'montant',
        'libelle',
        'reference_externe',
        'tiers',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'montant' => 'decimal:2',
    ];

    /**
     * Relation: Une transaction appartient à un compte
     */
    public function account()
    {
        return $this->belongsTo(BanqueAccount::class, 'banque_account_id', 'banque_account_id');
    }

    /**
     * Scope pour les transactions par type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    /**
     * Scope pour les transactions par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour les transactions validées
     */
    public function scopeValidated($query)
    {
        return $query->where('status', 'valide');
    }

    /**
     * Scope pour les transactions par période
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
}
