<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // SuperAdmin peut tout faire
        Gate::before(function (User $user, string $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // Gates basés sur les rôles
        Gate::define('manage-users', fn(User $user) => 
            $user->hasMinimumRole(Role::ADMIN)
        );

        Gate::define('view-admin-dashboard', fn(User $user) => 
            $user->hasMinimumRole(Role::ADMIN)
        );

        Gate::define('manage-content', fn(User $user) => 
            $user->hasMinimumRole(Role::MANAGER)
        );

        // Gates basés sur les permissions
        foreach (config('roles.permissions', []) as $role => $permissions) {
            foreach ($permissions as $permission) {
                if ($permission === '*') continue;
                
                Gate::define($permission, fn(User $user) => 
                    $user->role->hasPermission($permission)
                );
            }
        }
    }
}