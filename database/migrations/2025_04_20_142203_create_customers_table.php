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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id'); // auto-incremented PK
            $table->string('name');
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password'); // hashed password
            $table->boolean('is_deleted'); // soft delete flag
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
