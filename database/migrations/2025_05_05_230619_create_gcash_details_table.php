<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGcashDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcash_details', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // GCash name
            $table->string('reference_number'); // Reference number
            $table->string('image')->nullable(); // Path to the attached image
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcash_details');
    }
}