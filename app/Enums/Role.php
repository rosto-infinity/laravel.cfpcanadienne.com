<?php
namespace App\Enums;

enum Role: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    /**
     * Obtenir tous les rôles disponibles
     */
    public static function availableRoles(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Vérifier si un rôle existe
     */
    public static function exists(?string $role): bool
    {
        // Gérer le cas où $role est null
        if ($role === null) {
            return false;
        }
        
        return in_array(strtolower(trim($role)), self::availableRoles());
    }

    /**
     * Créer une instance depuis une chaîne avec validation
     */
    public static function fromString(?string $role): ?self
    {
        if ($role === null) {
            return null;
        }
        
        $role = strtolower(trim($role));
        return self::tryFrom($role);
    }

    /**
     * Obtenir le rôle par défaut
     */
    public static function default(): self
    {
        $defaultRole = config('roles.default_role', 'user');
        $role = self::tryFrom($defaultRole);
        
        // Fallback si le rôle configuré n'existe pas
        return $role ?? self::USER;
    }

    /**
     * Obtenir le rôle superadmin
     */
    public static function superadmin(): self
    {
        $superadminRole = config('roles.superadmin_role', 'superadmin');
        $role = self::tryFrom($superadminRole);
        
        // Fallback si le rôle configuré n'existe pas
        return $role ?? self::SUPERADMIN;
    }

    /**
     * Label traduit du rôle
     */
    public function label(): string
    {
        return match($this) {
            self::SUPERADMIN => __('Super Administrateur'),
            self::ADMIN => __('Administrateur'),
            self::MANAGER => __('Gestionnaire'),
            self::USER => __('Utilisateur'),
        };
    }

    /**
     * Niveau hiérarchique du rôle
     */
    public function level(): int
    {
        return match($this) {
            self::SUPERADMIN => 100,
            self::ADMIN => 80,
            self::MANAGER => 50,
            self::USER => 10,
        };
    }

    /**
     * Vérifier si le rôle a une permission spécifique
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = config("roles.permissions.{$this->value}", []);
        return in_array('*', $permissions) || in_array($permission, $permissions);
    }

    /**
     * Obtenir toutes les permissions du rôle
     */
    public function permissions(): array
    {
        return config("roles.permissions.{$this->value}", []);
    }
}
