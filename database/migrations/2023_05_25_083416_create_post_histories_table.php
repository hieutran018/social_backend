<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->text('post_content')->nullable();
            $table->foreignId('user_id');
            $table->integer('privacy');
            $table->foreignId('parent_post')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->foreignId('feel_activity_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_histories');
    }
}
