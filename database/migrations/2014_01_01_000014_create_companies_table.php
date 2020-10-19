<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('companies')) {
            return;
       }
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('facebook_id')->nullable();
            $table->string('instagram_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address')->nullable();
            $table->text('paypal_client_key')->nullable();
            $table->text('paypal_secret_key')->nullable();
            $table->string('paypal_environtment')->nullable()->default('sandbox');
            $table->text('card_client_key')->nullable();
            $table->text('card_secret_key')->nullable();
            $table->string('card_environtment')->nullable()->default('sandbox');
            $table->boolean('has_custom_email_credentials')->default(false);
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->unsignedInteger('min_transactions');
            $table->unsignedInteger('max_transactions');
            $table->unsignedInteger('commission_per_transaction');
            $table->boolean('is_percentage')->default(false);
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
        Schema::dropIfExists('companies');
    }
}
