<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->foreign('server_players_online_id')->references('id')->on('server_players_online')->onDelete('cascade');
            $table->foreign('server_statistics_id')->references('id')->on('server_statistics')->onDelete('cascade');
        });

        Schema::table('server_statistics', function (Blueprint $table) {
            $table->foreign('server_id')->references('id')->on('servers');
        });

        Schema::table('server_players_online', function (Blueprint $table) {
            $table->foreign('server_id')->references('id')->on('servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign(['server_players_online_id']);
            $table->dropForeign(['server_statistics_id']);
        });

        Schema::table('server_statistics', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
        });

        Schema::table('server_players_online', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
        });
    }
}
