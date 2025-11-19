<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $credentials = [
            'name' => env('SUPERADMIN_NAME'),
            'email' => env('SUPERADMIN_EMAIL'),
            'password' => env('SUPERADMIN_PASSWORD'),
        ];

        // Validation des données
        $validator = Validator::make($credentials, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->command->error('❌ Erreur de validation des données du superadmin:');
            foreach ($validator->errors()->all() as $error) {
                $this->command->error("  • {$error}");
            }
            return;
        }

        // Vérifier que le rôle superadmin existe dans la config
        $superadminRole = Role::superadmin();
        if (!Role::exists($superadminRole->value)) {
            $this->command->error("❌ Le rôle '{$superadminRole->value}' n'existe pas dans APP_USER_ROLES");
            $this->command->info("   Rôles disponibles: " . implode(', ', Role::values()));
            return;
        }

        // Vérifier si un superadmin existe déjà
        if (User::where('role', $superadminRole->value)->exists()) {
            $this->command->warn('⚠️  Un superadmin existe déjà dans la base de données.');
            return;
        }

        // Créer le superadmin
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'role' => $superadminRole,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Superadmin créé avec succès!');
        $this->command->table(
            ['Champ', 'Valeur'],
            [
                ['ID', $user->id],
                ['Nom', $user->name],
                ['Email', $user->email],
                ['Rôle', $user->role->value],
            ]
        );
    }
}
