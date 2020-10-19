<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddColumnsToCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('carts') == false) 
        {
            return;
        }
        Schema::table('carts', function (Blueprint $table) {
            // $table->softDeletes();
            // $table->boolean('was_reminded_hour')->default(false);
            // $table->boolean('was_reminded_day')->default(false);
            // $table->boolean('was_reminded_week')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            // $table->dropColumn('deleted_at');
            $table->dropColumn('was_reminded_hour');
            $table->dropColumn('was_reminded_day');
            $table->dropColumn('was_reminded_week');
        });
    }
}
