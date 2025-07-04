<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table des tags
        Schema::create('artifact_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        
        // Table pivot many-to-many
        Schema::create('artifact_tag', function (Blueprint $table) {
            $table->foreignId('artifact_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('artifact_tags')->onDelete('cascade');
            $table->primary(['artifact_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artifact_tag');
        Schema::dropIfExists('artifact_tags');
    }
};