<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayersOnline extends Model
{
    /**
     * @var string
     */
    protected $table = 'players_online';

    /**
     * @var array
     */
    protected $fillable = [
        'ip',
        'currentplayers',
        'maxplayers',
    ];

    public function server()
    {
        return $this->belongsTo('App\Server');
    }
}
