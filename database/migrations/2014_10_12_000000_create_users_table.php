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
            $table->bigIncrements('id');
            $table->string('email')->nullable();
            $table->string('social_provider');
            $table->string('social_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')->unique();
            $table->date('birthday');
            $table->string('phone', 10)->nullable();
            $table->string('avatar')->nullable();
            $table->string('bio')->nullable();
            $table->boolean('tick')->default(false);
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
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
