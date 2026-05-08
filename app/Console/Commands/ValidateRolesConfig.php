<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ValidateRolesConfig extends Command
{
    protected $signature = 'roles:validate';

    protected $description = 'Valider la configuration des rôles';

    public function handle(): int
    {
        $this->info('🔍 Validation de la configuration des rôles...');
        $this->newLine();

        // Vérifier les rôles dans .env
        $envRoles = env('APP_USER_ROLES');
        if (! $envRoles) {
            $this->error('❌ APP_USER_ROLES n\'est pas défini dans .env');

            return 1;
        }

        $roles = config('roles.roles');
        $this->info('✅ Rôles configurés: '.implode(', ', $roles));
        $this->newLine();

        // Vérifier le rôle par défaut
        $defaultRole = config('roles.default_role');
        if (! in_array($defaultRole, $roles)) {
            $this->error("❌ Le rôle par défaut '{$defaultRole}' n'existe pas dans APP_USER_ROLES");

            return 1;
        }
        $this->info("✅ Rôle par défaut: {$defaultRole}");

        // Vérifier le rôle superadmin
        $superadminRole = config('roles.superadmin_role');
        if (! in_array($superadminRole, $roles)) {
            $this->error("❌ Le rôle superadmin '{$superadminRole}' n'existe pas dans APP_USER_ROLES");

            return 1;
        }
        $this->info("✅ Rôle superadmin: {$superadminRole}");
        $this->newLine();

        // Vérifier la hiérarchie
        $hierarchy = config('roles.hierarchy');
        $missingInHierarchy = array_diff($roles, array_keys($hierarchy));
        if (! empty($missingInHierarchy)) {
            $this->warn('⚠️  Rôles sans hiérarchie définie: '.implode(', ', $missingInHierarchy));
        } else {
            $this->info('✅ Tous les rôles ont une hiérarchie définie');
        }

        // Vérifier les permissions
        $permissions = config('roles.permissions');
        $missingInPermissions = array_diff($roles, array_keys($permissions));
        if (! empty($missingInPermissions)) {
            $this->warn('⚠️  Rôles sans permissions définies: '.implode(', ', $missingInPermissions));
        } else {
            $this->info('✅ Tous les rôles ont des permissions définies');
        }

        $this->newLine();
        $this->info('✅ Configuration validée avec succès!');

        return 0;
    }
}
