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
        Schema::create('categories', function (Blueprint $table) {
            // PK
            $table->id();

            // Tabellen-spezifische Attribute
            $table->string('ctgry_name')->nullable();
            $table->text('ctgry_description')->nullable();

            // Laraval-Standard -> gibt 'created_at' und 'updated_at' aus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
