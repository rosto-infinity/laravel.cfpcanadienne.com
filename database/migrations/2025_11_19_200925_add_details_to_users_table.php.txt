<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $roles = config('roles.roles', ['user']);
        $defaultRole = config('roles.default_role', 'user');

        Schema::table('users', function (Blueprint $table) use ($roles, $defaultRole): void {
            // Utiliser string au lieu d'enum pour plus de flexibilité
            $table->string('role', 20)
                ->after('email')
                ->default($defaultRole)
                ->index();
        });   
    }

    public function down(): void
    { 
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('role');
        });
    }
};
