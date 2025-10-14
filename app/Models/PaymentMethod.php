<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentMethod extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'payment_methods';

    protected $primaryKey = 'payment_method_id';
    public $incrementing = false; // car UUID
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'payment_method_id', 'payment_method_id');
    }
}
