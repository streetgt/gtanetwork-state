<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUtilNatives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('util_natives', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('category',
                ['PLAYER',
                    'ENTITY',
                    'PED',
                    'VEHICLE',
                    'OBJECT',
                    'AI',
                    'GAMEPLAY',
                    'AUDIO',
                    'CUTSCENE',
                    'INTERIOR',
                    'CAM',
                    'WEAPON',
                    'ITEMSET',
                    'STREAMING',
                    'SCRIPT',
                    'UI',
                    'GRAPHICS',
                    'STATS',
                    'BRAIN',
                    'MOBILE',
                    'APP',
                    'TIME',
                    'PATHFIND',
                    'CONTROLS',
                    'DATAFILE',
                    'FIRE',
                    'DECISIONEVENT',
                    'ZONE',
                    'ROPE',
                    'WATER',
                    'WORLDPROBE',
                    'NETWORK',
                    'NETWORKCASH',
                    'DLC1',
                    'DLC2',
                    'SYSTEM',
                    'DECORATOR',
                    'SOCIALCLUB',
                    'UNK',
                    'UNK1',
                    'UNK2',
                    'UNK3']
            );
            $table->string('type')->nullable(false);
            $table->string('name',500);
            $table->string('hash',100)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('util_natives');
    }
}
