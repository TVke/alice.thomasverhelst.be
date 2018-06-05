<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('pawn')->nullable()->default(null);
            $table->json('position');
            $table->json('objects')->nullable()->default(null);
            $table->json('current_object')->nullable()->default(null);
            $table->integer('score')->nullable()->default(null);
            $table->boolean('active')->default(false);

            $table->unsignedInteger('game_session_id')->nullable()->default(null);
            $table->foreign('game_session_id')->references('id')->on('game_sessions')->onDelete('cascade');

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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('players');
    }
}
