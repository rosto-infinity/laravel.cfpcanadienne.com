<?php

return [
    // Récupérer les rôles depuis .env (en minuscules pour la cohérence)
    'roles' => array_map(
        'strtolower',
        array_filter(
            array_map('trim', explode(',', env('APP_USER_ROLES', 'user,manager,admin,superadmin')))
        )
    ),
    
    // Rôle par défaut
    'default_role' => strtolower(env('APP_DEFAULT_ROLE', 'user')),
    
    // Rôle superadmin
    'superadmin_role' => strtolower(env('APP_SUPERADMIN_ROLE', 'superadmin')),
    
    // Hiérarchie des rôles (ordre d'importance)
    'hierarchy' => [
        'superadmin' => 100,
        'admin' => 75,
        'manager' => 50,
        'user' => 10,
    ],
    
    // Permissions par rôle
    'permissions' => [
        'superadmin' => ['*'], // Toutes les permissions
        'admin' => ['manage_users', 'view_dashboard', 'edit_content', 'delete_content'],
        'manager' => ['view_dashboard', 'edit_content'],
        'user' => ['view_content'],
    ],
];