<?php

namespace App\Listeners;

use App\Server;
use App\Events\UpdateServerEvent;
use App\Events\UpdateServerInfoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateServerInfo implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  UpdateServerInfoEvent $event
     * @return void
     */
    public function handle(UpdateServerInfoEvent $event)
    {
        $item = $event->server;

        $server = Server::where('ip', $item->get('IP'))->first();

        if($server == null) {
            event(new UpdateServerEvent($item));
            return;
        }

        $data = [
            'currentplayers' => $item->get('CurrentPlayers'),
            'maxplayers'     => $item->get('MaxPlayers'),
            'passworded'     => $item->get('Passworded')
        ];

        var_dump($data['passworded']);

        if ($server->info()->count()) {
            $server->info()->update($data);
        } else {
            $row = $server->info()->create($data);
            $server->server_players_online_id = $row->id;
            $server->save();
        }
    }
}
