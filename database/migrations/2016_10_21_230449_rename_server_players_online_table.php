<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameServerPlayersOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('server_players_online', 'server_info');
        Schema::table('server_info', function (Blueprint $table) {
            $table->boolean('passworded')->after('maxplayers')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('server_info', 'server_players_online');
        Schema::create('stats', function (Blueprint $table) {
            $table->dropColumn('passworded');
        });
    }
}
