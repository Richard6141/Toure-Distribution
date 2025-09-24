<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'client_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name_client',
        'client_type_id',
        'adresse',
        'city',
        'email',
        'phonenumber',
        'credit_limit',
        'current_balance',
        'is_active',
    ];

    /**
     * Boot method pour générer un UUID automatiquement.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->client_id)) {
                $model->client_id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation : un client appartient à un type de client.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'client_type_id');
    }
}