<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * @var string
     */
    protected $table = 'servers';

    /**
     * @var array
     */
    protected $fillable = [
        'ip',
        'servername',
        'port',
        'currentplayers',
        'maxplayers',
        'gamemode',
        'map',
        'country',
    ];

    /**
     * @return mixed
     */
    public function statistics()
    {
        return $this->hasOne('App\ServerStatistic');
    }

    public function playersOnline()
    {
        return $this->hasOne('App\PlayersOnline');
    }
}
