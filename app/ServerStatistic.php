<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerStatistic extends Model
{
    /**
     * @var string
     */
    protected $table = 'server_statistics';

    /**
     * @var array
     */
    protected $fillable = [
        'server_id',
        'daily_stats',
        'highest_peak',
    ];

    public function server()
    {
        return $this->belongsTo('App\Server');
    }
}
