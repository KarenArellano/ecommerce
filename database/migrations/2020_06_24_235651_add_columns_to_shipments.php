<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShipments extends Migration
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
        
        Schema::table('shipments', function (Blueprint $table) 
        {
            // $table->string('rate_id')->nullable();
            // $table->string('currency')->nullable();
            // $table->string('price')->nullable();
            // $table->string('service_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('shipments') == false) 
        {
            return;
        }
        
        Schema::table('shipments', function (Blueprint $table) 
        {
            $table->dropColumn('rate_id');
        });
    }
}
