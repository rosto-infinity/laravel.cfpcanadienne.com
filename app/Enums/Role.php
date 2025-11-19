<?php
namespace App\Enums;

enum Role: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    /**
     * Obtenir tous les rôles configurés dans .env
     */
    public static function values(): array
    {
        return config('roles.roles', ['user']);
    }

    /**
     * Vérifier si un rôle existe dans la configuration
     */
    public static function exists(string $role): bool
    {
        return in_array(strtolower($role), self::values());
    }

    /**
     * Créer une instance depuis une chaîne avec validation
     */
    public static function fromString(string $role): ?self
    {
        $role = strtolower(trim($role));
        
        if (!self::exists($role)) {
            return null;
        }

        return self::tryFrom($role);
    }

    /**
     * Obtenir le rôle par défaut depuis la config
     */
    public static function default(): self
    {
        $defaultRole = config('roles.default_role', 'user');
        return self::from($defaultRole);
    }

    /**
     * Obtenir le rôle superadmin depuis la config
     */
    public static function superadmin(): self
    {
        $superadminRole = config('roles.superadmin_role', 'superadmin');
        return self::from($superadminRole);
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
        return config("roles.hierarchy.{$this->value}", 0);
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