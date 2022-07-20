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
            $table->string('username');
            $table->string('nicename')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('registered')->useCurrent();
            $table->string('displayname')->nullable();
            $table->string('firtname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('description')->nullable();
            $table->string('capabilities')->nullable();
            $table->string('user_group')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->integer('points')->nullable()->default(0);
            $table->integer('followers')->nullable()->default(0);
            $table->integer('questions')->nullable()->default(0);
            $table->integer('answers')->nullable()->default(0);
            $table->integer('best_answers')->nullable()->default(0);
            $table->integer('posts')->nullable()->default(0);
            $table->integer('comments')->nullable()->default(0);
            $table->integer('notifications')->nullable()->default(0);
            $table->integer('new_notifications')->nullable()->default(0);
            $table->boolean('verified')->nullable()->default(false);
            $table->boolean('admin')->nullable()->default(false);
            $table->boolean('status')->default(true);
            $table->integer('badge_id')->nullable();
            $table->string('profile_crediential')->nullable();
            $table->rememberToken();
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
