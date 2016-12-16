<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerInfo extends Model
{
    /**
     * @var string
     */
    protected $table = 'server_info';

    /**
     * @var array
     */
    protected $fillable = [
        'ip',
        'server_id',
        'currentplayers',
        'maxplayers',
    ];

    /**
     * Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
