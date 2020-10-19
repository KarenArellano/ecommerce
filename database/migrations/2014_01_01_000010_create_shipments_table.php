<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shipments')) {
            return;
       }
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->string('shipper')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url_provider',700)->nullable();
            $table->string('label_url', 700)->nullable();
            $table->string('currency')->nullable();
            $table->string('price')->nullable();
            $table->string('rate_id')->nullable();
            $table->string('service_name')->nullable();
            $table->timestamp('shipped_at')->nullable();
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
        Schema::dropIfExists('shipments');
    }
}
