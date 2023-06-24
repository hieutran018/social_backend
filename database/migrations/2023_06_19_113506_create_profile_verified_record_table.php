<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileVerifiedRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_verified_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('document_type');
            $table->string('verified_image_front')->nullable();
            $table->string('verified_image_backside')->nullable();
            $table->string('outstanding_type');
            $table->string('county');
            $table->text('quote_one')->nullable();
            $table->text('quote_two')->nullable();
            $table->text('quote_three')->nullable();
            $table->text('quote_four')->nullable();
            $table->text('quote_five')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('profile_verified_records');
    }
}
