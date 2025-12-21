<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    // --- Helpers de rôle (Syntaxe corrigée) ---

    public function isSuperAdmin(): bool 
    {
        return $this->role === Role::SUPERADMIN;
    }
    
    public function isAdmin(): bool 
    {
        return $this->role?->isAtLeast(Role::ADMIN) ?? false;
    }

    public function hasAnyRole(array $roles): bool 
    {
        return in_array($this->role, $roles, true);
    }

    // Surcharge de l'autorisation native Laravel
    public function can($ability, $arguments = []): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        return $this->role?->hasPermission($ability) || parent::can($ability, $arguments);
    }

    protected static function booted(): void
    {
        // Ici l'usage de fn() est correct car c'est une closure (fonction anonyme)
        static::creating(function (User $user) {
            $user->role ??= Role::default();
        });

        static::updating(function (User $user) {
            if ($user->isDirty('role')) {
                
                 //$operator = auth()->user();
                $operator = Auth::user();
                
                if (!$operator || !$operator->isSuperAdmin()) {
                    Log::warning("Tentative de modification de rôle non autorisée par l'utilisateur ID: " . ($operator?->id ?? 'invité'));
                    throw new \Exception('Seul un SuperAdmin peut modifier les rôles.');
                }
                
                // Protection du dernier SuperAdmin
                if ($user->getOriginal('role') === Role::SUPERADMIN) {
                    $superAdminCount = self::where('role', Role::SUPERADMIN)->count();
                    if ($superAdminCount <= 1) {
                        throw new \Exception('Impossible de modifier le rôle du dernier SuperAdmin.');
                    }
                }
            }
        });
    }
}
