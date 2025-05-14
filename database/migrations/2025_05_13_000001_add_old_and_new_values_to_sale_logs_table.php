<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldAndNewValuesToSaleLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_logs', function (Blueprint $table) {
            $table->text('old_value')->nullable(); // Store old values for updates
            $table->text('new_value')->nullable(); // Store new values for updates
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_logs', function (Blueprint $table) {
            $table->dropColumn(['old_value', 'new_value']);
        });
    }
}
