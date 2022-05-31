<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_user', function (Blueprint $table) {
            $table->foreignId('game_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('kills')->default(0);
            $table->boolean('alive')->default(true);
            $table->timestamp('when_killed')->nullable(true);
            $table->unsignedBigInteger('target_id')->nullable(true);
            $table->foreign('target_id')->references('id')->on('users');
            $table->unique('target_id');
            $table->primary(['game_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_user');
    }
}
