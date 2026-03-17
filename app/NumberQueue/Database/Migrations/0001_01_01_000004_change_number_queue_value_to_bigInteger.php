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
        Schema::table('number_queue', function (Blueprint $table) {
            $table->unsignedBigInteger('value')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('number_queue', function (Blueprint $table) {
            $table->unsignedInteger('value')->nullable(false)->change();
        });
    }
};
