<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('emails') == false) 
        {
            return;
        }
        
        Schema::table('emails', function (Blueprint $table) 
        {
            // $table->string('background_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('emails') == false) 
        {
            return;
        }

        Schema::table('emails', function (Blueprint $table) 
        {
            $table->dropColumn('background_color');
        });
    }
}
