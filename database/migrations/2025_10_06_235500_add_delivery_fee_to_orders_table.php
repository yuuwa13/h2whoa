<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('orders', 'delivery_fee')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('delivery_fee', 8, 2)->nullable()->default(0)->after('customer_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('orders', 'delivery_fee')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('delivery_fee');
            });
        }
    }
};
