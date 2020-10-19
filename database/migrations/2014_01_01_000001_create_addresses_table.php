<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('addresses')) {
            return;
        }
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('addressable');
            $table->string('alias')->nullable();
            $table->string('user_in_charge')->nullable();
            $table->string('line');
            $table->string('secondary_line')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('US');
            $table->string('zipcode', 30);
            $table->string('references')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->string('taxable_id')->nullable();
            $table->string('phone', 50)->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
