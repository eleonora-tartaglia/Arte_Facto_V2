<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artifacts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            
            // Relations
            $table->foreignId('civilization_id')->constrained();
            $table->foreignId('source_id')->nullable()->constrained('artifact_sources');
            
            // Infos archéologiques
            $table->string('discovery_site')->nullable();
            $table->string('discovery_year')->nullable();
            $table->string('archaeologist')->nullable();
            $table->text('discovery_context')->nullable();
            
            // Caractéristiques
            $table->json('materials')->nullable();
            $table->json('dimensions')->nullable();
            $table->enum('condition_grade', ['Perfect', 'Excellent', 'Very Good', 'Good', 'Fair'])->nullable();
            $table->text('condition_notes')->nullable();
            $table->boolean('has_restoration')->default(false);
            
            // Authentification
            $table->boolean('authenticated')->default(true);
            $table->string('authentication_certificate')->nullable();
            
            // Provenance & légendes
            $table->json('provenance_history')->nullable();
            $table->text('legend')->nullable();
            
            // Commerce
            $table->decimal('price', 10, 2);
            $table->enum('sale_type', ['immediate', 'auction']);
            $table->enum('status', ['available', 'in_cart', 'sold'])->default('available');
            
            // Images & marketing
            $table->json('images')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('wishlist_count')->default(0);
            
            $table->timestamps();
            
            // Index pour performance
            $table->index(['civilization_id', 'status', 'sale_type']);
            // $table->fullText(['title', 'description', 'legend']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artifacts');
    }
};