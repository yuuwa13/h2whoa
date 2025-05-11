<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gcash_details', function (Blueprint $table) {
            if (!Schema::hasColumn('gcash_details', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable();
            }
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gcash_details', function (Blueprint $table) {
            //
        });
    }
};
