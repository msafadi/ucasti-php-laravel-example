<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->bigInteger('following_id')->unsigned();
            $table->bigInteger('follower_id')->unsigned();
            $table->timestamps();

            $table->primary(['following_id', 'follower_id']);
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('post_id')->unsigned();
            $table->timestamps();

            $table->primary(['user_id', 'post_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('username')->unique()->after('id');
        });

        Schema::table('posts', function(Blueprint $table) {
            $table->integer('likes')->unsigned()->default(0)->after('user_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
        Schema::dropIfExists('likes');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('likes');
        });
    }
}
