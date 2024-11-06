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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->unique();
            $table->string('name', 255);
            $table->string('lastname', 255);
            $table->string('password', 255);
            $table->string('email', 255);
            $table->string('identification_number', 255);
            $table->string('identification_type', 255);
            $table->integer('status')->default(1);
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('block_date')->nullable();
            $table->boolean('is_block')->default(false);
            $table->timestamps(); // Esto incluye created_at y updated_at
            $table->boolean('is_delete')->default(false);
            $table->string('favorite_phrase', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
