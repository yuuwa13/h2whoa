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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->unsignedBigInteger('order_id')->nullable(); // Link to orders
            $table->enum('sale_type', ['web', 'phone', 'on-site']); // Sale type
            $table->string('unique_sale_id')->unique(); // Unique ID for each sale
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraint
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
