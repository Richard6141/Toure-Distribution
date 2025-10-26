<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banque extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'banques';
    protected $primaryKey = 'banque_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'code',
        'adresse',
        'contact_info',
        'isActive',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    /**
     * Relation: Une banque a plusieurs comptes
     */
    public function accounts()
    {
        return $this->hasMany(BanqueAccount::class, 'banque_id', 'banque_id');
    }

    /**
     * Scope pour les banques actives
     */
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }
}
