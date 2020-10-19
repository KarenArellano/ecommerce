<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shipments') == false) 
        {
            return;
        }
        Schema::table('shipments', function (Blueprint $table) {
            // $table->string('tracking_number')->nullable();
            // $table->string('tracking_url_provider', 700)->nullable();
            // $table->string('label_url', 700)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
            $table->dropColumn('tracking_url_provider');
            $table->dropColumn('label_url');
        });
    }
}
