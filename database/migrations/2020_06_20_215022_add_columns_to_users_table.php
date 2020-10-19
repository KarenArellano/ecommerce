<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') == false) 
        {
            return;
        }
        
        Schema::table('users', function (Blueprint $table) 
        {
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') == false) 
        {
            return;
        }

        Schema::table('users', function (Blueprint $table) 
        {
            $table->dropColumn('phone');
        });
    }
}
