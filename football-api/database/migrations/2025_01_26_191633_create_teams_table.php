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
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id')->unique();
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('tla')->nullable();
            $table->string('crest')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->integer('founded')->nullable();
            $table->string('venue')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('coach_nationality')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
