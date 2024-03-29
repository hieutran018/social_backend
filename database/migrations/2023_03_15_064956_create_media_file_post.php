<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFilePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_file_posts', function (Blueprint $table) {
            $table->id();
            $table->string('media_file_name');
            $table->string('media_type');
            $table->foreignId('post_id');
            $table->foreignId('user_id');
            $table->foreignId('group_id')->nullable();
            $table->foreignId('post_history_id')->nullable();
            $table->boolean('isAvatar')->nullable();
            $table->boolean('isCover')->nullable();
            $table->foreignId('album_id')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('media_file_posts');
    }
}
