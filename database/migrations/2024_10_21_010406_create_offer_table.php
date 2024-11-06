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
        Schema::create('offers', function (Blueprint $table) {
            $table->id(); // Equivalente a SERIAL en MySQL (auto-incremental)
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->integer('deadline');
            $table->decimal('price', 10, 2);
            $table->integer('status')->default(1)->nullable();
            $table->string('type', 255);
            $table->string('category', 255);
            $table->uuid('user_id');
            $table->timestamps(); // Esto incluye created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer');
    }
};
