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
        Schema::create('feed_results', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('result_id');
            $table->boolean('visible');
            $table->foreignId('owner_id');
            $table->boolean('public')->default(0);
            $table->string('relevance')->default(.5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_results');
    }
};
