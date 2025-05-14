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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->string('action'); // CRUD action type
            $table->json('old_values')->nullable(); // Old values for updates
            $table->json('new_values')->nullable(); // New values for updates
            $table->timestamps();

            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
