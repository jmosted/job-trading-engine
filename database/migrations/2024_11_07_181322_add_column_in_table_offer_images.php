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
        Schema::table('offer_images', function (Blueprint $table) {
            $table->string('file_name');
            $table->string('file_extension');
            $table->string('image');
            $table->string('user_id');
            $table->unsignedInteger('offer_id');
            $table->unsignedInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_images', function (Blueprint $table) {
            $table->dropColumn('file_name');
            $table->dropColumn('file_extension');
            $table->dropColumn('image');
            $table->dropColumn('user_id');
            $table->dropColumn('offer_id');
            $table->dropColumn('status');
        });
    }
};
