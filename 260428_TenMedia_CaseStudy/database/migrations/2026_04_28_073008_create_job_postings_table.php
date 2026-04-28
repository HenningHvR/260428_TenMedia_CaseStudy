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
        Schema::create('job_postings', function (Blueprint $table) {
            //PK
            $table->id();

            // Tabellen-spezifische Attribute
            $table->string('title');
            $table->text('jp_description')->nullable();
            $table->string('jp_location')->nullable();
            $table->string('experience-level')->nullable();
            $table->string('employment_type')->nullable();
            $table->decimal('salary', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);

            // Laraval-Standard -> gibt 'created_at' und 'updated_at' aus
            $table->timestamps();
            
            // FK hinzufügen
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
