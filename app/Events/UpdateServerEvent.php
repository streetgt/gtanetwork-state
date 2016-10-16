<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UpdateServerEvent
{
    use SerializesModels;

    /**
     * @var
     */
    public $server;

    /**
     * UpdateServer constructor.
     * @param $server
     */
    public function __construct(Collection $server)
    {
        $this->server = $server;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
