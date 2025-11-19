<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role' => Role::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function partenaires()
{
    return $this->hasMany(Partenaire::class);
}

/**
     * Accesseur pour s'assurer que le rôle est valide
     */
    protected function role(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Si le rôle n'existe pas dans la config, utiliser le rôle par défaut
                if (!Role::exists($value)) {
                   \Log::warning("Rôle invalide détecté: {$value} pour l'utilisateur {$this->id}");
                    return Role::default();
                }
                return Role::from($value);
            },
            set: function ($value) {
                // Convertir en string si c'est un Enum
                if ($value instanceof Role) {
                    return $value->value;
                }
                
                // Valider que le rôle existe
                $roleString = strtolower(trim($value));
                if (!Role::exists($roleString)) {
                    throw new \InvalidArgumentException("Rôle invalide: {$value}");
                }
                
                return $roleString;
            }
        );
    }

    // Vérifications de rôle
    public function isSuperAdmin(): bool
    {
        return $this->role === Role::superadmin();
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [Role::superadmin(), Role::ADMIN]);
    }

    public function hasRole(Role|string $role): bool
    {
        if (is_string($role)) {
            $role = Role::fromString($role);
            if (!$role) {
                return false;
            }
        }
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasMinimumRole(Role|string $minimumRole): bool
    {
        if (is_string($minimumRole)) {
            $minimumRole = Role::fromString($minimumRole);
            if (!$minimumRole) {
                return false;
            }
        }
        return $this->role->level() >= $minimumRole->level();
    }

    public function can($ability, $arguments = []): bool
    {
        // SuperAdmin peut tout faire
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        return $this->role->hasPermission($ability) || parent::can($ability, $arguments);
    }

    // Protection contre les modifications non autorisées
    protected static function booted(): void
    {
        // Valider le rôle avant la création
        static::creating(function (User $user) {
            if (!isset($user->role)) {
                $user->role = Role::default();
            }
        });

        // Empêcher la modification du rôle sauf par un superadmin
        static::updating(function (User $user) {
            if ($user->isDirty('role')) {
                $currentUser = auth()->user();
                if (!$currentUser || !$currentUser->isSuperAdmin()) {
                    throw new \Exception('Seul un superadmin peut modifier les rôles.');
                }
                
                // Empêcher la suppression du dernier superadmin
                if ($user->getOriginal('role') === Role::superadmin()->value) {
                    $superadminCount = self::where('role', Role::superadmin()->value)->count();
                    if ($superadminCount <= 1) {
                        throw new \Exception('Impossible de modifier le rôle du dernier superadmin.');
                    }
                }
            }
        });

        // Empêcher la suppression du dernier superadmin
        static::deleting(function (User $user) {
            if ($user->role === Role::superadmin()) {
                $superadminCount = self::where('role', Role::superadmin()->value)->count();
                if ($superadminCount <= 1) {
                    throw new \Exception('Impossible de supprimer le dernier superadmin.');
                }
            }
        });
    }

}
