<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * Définir la clé primaire UUID
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Colonnes UUID à générer automatiquement
     */
    public function uniqueIds(): array
    {
        return ['user_id'];
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'phonenumber',
        'poste',
        'email',
        'password',
        'is_active',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'password_changed_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relations
     */
    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class, 'user_id', 'user_id');
    }

    /**
     * Vérifier si le compte est verrouillé
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Verrouiller le compte temporairement
     */
    public function lockAccount(int $minutes = 30): void
    {
        $this->update([
            'locked_until' => now()->addMinutes($minutes),
            'failed_login_attempts' => 0
        ]);
    }

    /**
     * Réinitialiser les tentatives de connexion
     */
    public function resetLoginAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);
    }

    /**
     * Enregistrer une tentative de connexion
     */
    public function recordLoginAttempt(bool $success, string $ip, string $reason = null): void
    {
        if ($success) {
            $this->update([
                'last_login_at' => now(),
                'last_login_ip' => $ip,
                'failed_login_attempts' => 0,
                'locked_until' => null
            ]);
        } else {
            $this->increment('failed_login_attempts');

            // Verrouiller après 5 tentatives échouées
            if ($this->failed_login_attempts >= 5) {
                $this->lockAccount();
            }
        }

        // Enregistrer dans le journal
        LoginAttempt::create([
            'user_id' => $this->user_id,
            'email' => $this->email,
            'ip_address' => $ip,
            'status' => $success ? 'success' : 'failed',
            'failure_reason' => $reason,
            'attempted_at' => now()
        ]);
    }

    /**
     * Vérifier si l'utilisateur doit changer son mot de passe
     * 
     * @return bool
     */
    public function shouldChangePassword(): bool
    {
        // Si password_changed_at n'existe pas, considérer qu'il faut changer
        if (!$this->password_changed_at) {
            return true;
        }

        // Vérifier si le mot de passe a plus de 90 jours (configurable)
        $passwordMaxAge = config('auth.password_max_age', 90); // 90 jours par défaut

        return $this->password_changed_at->addDays($passwordMaxAge)->isPast();
    }

    /**
     * Vérifier si l'email est vérifié
     * 
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Obtenir le temps restant avant déverrouillage du compte
     * 
     * @return int|null Minutes restantes, null si pas verrouillé
     */
    public function getRemainingLockTime(): ?int
    {
        if (!$this->isLocked()) {
            return null;
        }

        return now()->diffInMinutes($this->locked_until);
    }

    /**
     * Réinitialiser les tentatives de connexion échouées
     * 
     * @return void
     */
    public function resetFailedAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);
    }
}
