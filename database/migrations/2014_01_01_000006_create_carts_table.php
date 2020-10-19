<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('carts')) {
            return;
       }
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedDecimal('price')->nullable();
            $table->unsignedDecimal('total')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->boolean('was_reminded_hour')->default(false);
            $table->boolean('was_reminded_day')->default(false);
            $table->boolean('was_reminded_week')->default(false);

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
        Schema::dropIfExists('carts');
    }
}
