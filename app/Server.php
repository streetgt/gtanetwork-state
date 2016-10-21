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
        'players_online_id',
        'server_statistics_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statistics()
    {
        return $this->hasOne('App\ServerStatistic', 'server_id', 'id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne('App\ServerInfo', 'server_id', 'id');
    }
}
