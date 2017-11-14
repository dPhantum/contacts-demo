<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->index();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(1);
            $table->string('avatar_file')->nullable();
            $table->string('nickname')->nullable();
            $table->string('authenticator')->nullable();
            $table->string('authenticator_user_id')->nullable();
            $table->string('authenticator_token')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
