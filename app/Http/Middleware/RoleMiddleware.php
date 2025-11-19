<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Vérifier que l'utilisateur est authentifié
        if (!$request->user()) {
            Log::warning('Tentative d\'accès non authentifié', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);
            abort(401, 'Non authentifié');
        }

        $user = $request->user();

        // Si aucun rôle spécifié, autoriser l'accès
        if (empty($roles)) {
            return $next($request);
        }

        // Convertir et valider les rôles
        $requiredRoles = [];
        foreach ($roles as $role) {
            $roleEnum = Role::fromString($role);
            if (!$roleEnum) {
                Log::error("Rôle invalide dans le middleware: {$role}");
                abort(500, 'Configuration de rôle invalide');
            }
            $requiredRoles[] = $roleEnum;
        }

        // Vérifier si l'utilisateur a l'un des rôles requis
        if (!$user->hasAnyRole($requiredRoles)) {
            Log::warning('Accès refusé - rôle insuffisant', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role->value,
                'required_roles' => array_map(fn($r) => $r->value, $requiredRoles),
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);
            
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}