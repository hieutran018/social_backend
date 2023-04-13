<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgeinKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_file_posts', function(Blueprint $table){
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
        Schema::table('media_file_posts', function(Blueprint $table){
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('media_file_posts', function(Blueprint $table){
        //     $table->dropForeign('post_id'); //
        // });
        // Schema::table('media_file_posts', function(Blueprint $table){
        //     $table->dropForeign('album_id'); //
        // });
    }
}