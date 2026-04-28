<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            // PK
            $table->id();

            // Tabellen-spezifische Attribute
            $table->string('cmpny_name')->nullable();
            $table->text('cmpny_description')->nullable();
            $table->string('website')->nullable();
            $table->string('cmpny_location')->nullable();

            // Laraval-Standard -> gibt 'created_at' und 'updated_at' aus
            $table->timestamps();

            // FK hinzufügen
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
