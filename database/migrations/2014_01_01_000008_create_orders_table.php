<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('orders')) {
            return;
       }
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('transaction_id');
            $table->string('reference')->nullable();
            $table->unsignedDecimal('total', 16);
            $table->string('currency')->default('usd');
            $table->string('origin', 20);
            $table->timestamp('paid_at');
            $table->timestamp('notification_sent_at')->nullable();
            $table->string('paid_with');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('refund_at')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(
                new Expression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
