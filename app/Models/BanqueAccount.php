<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanqueAccount extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'banque_accounts';
    protected $primaryKey = 'banque_account_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'banque_id',
        'account_number',
        'account_name',
        'account_type',
        'titulaire',
        'balance',
        'statut',
        'date_ouverture',
        'isActive',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'date_ouverture' => 'date',
        'isActive' => 'boolean',
    ];

    /**
     * Relation: Un compte appartient à une banque
     */
    public function banque()
    {
        return $this->belongsTo(Banque::class, 'banque_id', 'banque_id');
    }

    /**
     * Relation: Un compte a plusieurs transactions
     */
    public function transactions()
    {
        return $this->hasMany(BanqueTransaction::class, 'banque_account_id', 'banque_account_id');
    }

    /**
     * Scope pour les comptes actifs
     */
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    /**
     * Scope pour les comptes par statut
     */
    public function scopeByStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Méthode pour débiter le compte
     */
    public function debit($montant)
    {
        $this->balance -= $montant;
        $this->save();
        return $this;
    }

    /**
     * Méthode pour créditer le compte
     */
    public function credit($montant)
    {
        $this->balance += $montant;
        $this->save();
        return $this;
    }
}
