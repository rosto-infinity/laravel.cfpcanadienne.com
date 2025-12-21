<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 20)
                ->after('email')
                ->default(Role::default()->value)
                ->index();
        });   
    }

    public function down(): void
    { 
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('role'));
    }
};
