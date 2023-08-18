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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locale', 3);
            $table->text('description');
            $table->string('slug', 40);
            $table->text('interest_urls');
            $table->string('type')->nullable();
            $table->foreignId('logo_id');
            $table->foreignId('country_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->boolean('accepts_erasmus');
            $table->string('website');
            $table->foreignId('location_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
