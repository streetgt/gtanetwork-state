<?php

namespace App;

use DB;
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
        return $this->hasOne(ServerStatistic::class, 'server_id', 'id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(ServerInfo::class, 'server_id', 'id');
    }

    /**
     * Check if a server is verified
     *
     * @return bool
     */
    public function isVerified()
    {
        $count = DB::table('servers_verified')->where('ip', $this->ip)->count();

        return ! $count == 0;
    }

    /**
     * Check if a server is verified
     *
     * @return bool
     */
    public function getWebsite()
    {
        $website = DB::table('servers_verified')->where('ip', $this->ip)->pluck('website')->first();

        return $website;
    }
}
