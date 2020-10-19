<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products')) {
            return;
        }
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedDecimal('price');
            $table->unsignedDecimal('unit_price')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->boolean('track_stock')->nullable()->default(true);
            $table->unsignedBigInteger('stock')->nullable()->default(0);
            $table->text('related')->nullable();
            $table->float('length', 8, 2)->default(12);
            $table->float('width', 8, 2)->default(12);
            $table->float('height', 8, 2)->default(12);
            $table->float('weight', 8, 2)->default(1);
            $table->string('mass_unit',8,2)->default('kg');
            $table->string('distance_unit',8,2)->default('in');
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
        Schema::dropIfExists('products');
    }
}
