<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('servername')->nullable(false);
            $table->string('ip')->unique();
            $table->integer('port')->unsigned();
            $table->string('gamemode')->nullable();
            $table->string('map')->nullable();
            $table->string('country')->nullable();
            $table->integer('server_players_online_id')->unsigned()->nullable();
            $table->integer('server_statistics_id')->unsigned()->nullable();
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
        Schema::dropIfExists('servers');
    }
}
