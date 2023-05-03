<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('displayName');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('sex')->nullable();
            $table->string('went_to')->nullable();
            $table->string('live_in')->nullable();
            $table->integer('relationship')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('token')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('isAdmin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
