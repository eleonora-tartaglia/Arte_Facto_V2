<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('artifact_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Un utilisateur ne peut avoir qu'une fois le même artefact dans son panier
            $table->unique(['user_id', 'artifact_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};