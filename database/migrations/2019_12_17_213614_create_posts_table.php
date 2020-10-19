<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('posts')) {
            return;
       }
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('excerpt');
            $table->text('content');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('cover', 100)->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
