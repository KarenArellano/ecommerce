<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cards')) {
            return;
       }
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('holder_name');
            $table->string('token');
            $table->string('brand');
            $table->string('bank')->nullable();
            $table->string('last_four', 4);
            $table->unsignedInteger('expiration_month');
            $table->unsignedInteger('expiration_year');
            $table->boolean('is_default')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(
                new Expression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            );
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
