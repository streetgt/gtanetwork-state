<?php

namespace App\Listeners;

use App\Server;
use App\Events\UpdatePlayersOnlineEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateServerOnlinePlayers implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  UpdatePlayersOnlineEvent  $event
     * @return void
     */
    public function handle(UpdatePlayersOnlineEvent $event)
    {
        $item = $event->server;

        try {

            $server = Server::where('ip', $item->get('IP'))->firstOrFail();

            $server->playersOnline->update([
                'currentplayers' => $item->get('CurrentPlayers'),
                'maxplayers' => $item->get('MaxPlayers'),
            ]);

        }
        catch (ModelNotFoundException $e)
        {
            // If server don't event exist lets add them in the list
            event(new UpdateServerEvent($item));
        }
    }
}
