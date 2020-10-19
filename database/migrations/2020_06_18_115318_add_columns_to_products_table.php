<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products') == false) 
        {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            // $table->float('length', 8, 2)->default(12);
            // $table->float('width', 8, 2)->default(12);
            // $table->float('height', 8, 2)->default(12);
            // $table->float('weight', 8, 2)->default(1);
            // $table->string('mass_unit', 8,2)->default('kg');
            // $table->string('distance_unit', 8,2)->default('in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('length');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('mass_unit');
            $table->dropColumn('distance_unit');
        });
    }
}
