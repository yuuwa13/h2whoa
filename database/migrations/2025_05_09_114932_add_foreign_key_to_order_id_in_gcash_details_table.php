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
            // Check if the column exists before adding it
            if (!Schema::hasColumn('gcash_details', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable();
            }

            // Check if the foreign key constraint exists before adding it
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'gcash_details' AND COLUMN_NAME = 'order_id' AND TABLE_SCHEMA = DATABASE()");
            $foreignKeyExists = collect($foreignKeys)->contains('CONSTRAINT_NAME', 'gcash_details_order_id_foreign');

            if (!$foreignKeyExists) {
                $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gcash_details', function (Blueprint $table) {
            if (Schema::hasColumn('gcash_details', 'order_id')) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            }
        });
    }
};
