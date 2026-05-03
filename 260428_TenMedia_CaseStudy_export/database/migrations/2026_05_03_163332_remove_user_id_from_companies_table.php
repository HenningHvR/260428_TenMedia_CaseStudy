<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Entfernt die alte direkte User-Zuordnung aus Companies.
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }

    // Stellt die alte User-Zuordnung wieder her.
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }
};
