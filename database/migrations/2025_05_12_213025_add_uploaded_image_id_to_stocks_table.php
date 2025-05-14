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
        Schema::table('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_image_id')->nullable()->after('maximum_orders_allowed');
            $table->foreign('uploaded_image_id')->references('id')->on('uploaded_images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['uploaded_image_id']);
            $table->dropColumn('uploaded_image_id');
        });
    }
};
