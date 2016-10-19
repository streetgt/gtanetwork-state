<?php

namespace App\Listeners;

use App\Server;
use App\Events\UpdatePlayersOnlineEvent;
use App\Stats;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateServerOnlinePlayers implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  UpdatePlayersOnlineEvent $event
     * @return void
     */
    public function handle(UpdatePlayersOnlineEvent $event)
    {
        $item = $event->server;

        try {

            $server = Server::where('ip', $item->get('IP'))->firstOrFail();

            $data = [
                'currentplayers' => $item->get('CurrentPlayers'),
                'maxplayers'     => $item->get('MaxPlayers'),
            ];

            if ($server->playersOnline()->count()) {
                $server->playersOnline()->update($data);
            } else {
                $row = $server->playersOnline()->create($data);
                $server->server_players_online_id = $row->id;
                $server->save();
            }

            $today_stats = Stats::where('date', Carbon::today())->first();

            if ($today_stats == null) {
                Stats::create([
                    'date' => Carbon::today(),
                    'min'  => $item->get('CurrentPlayers'),
                    'max'  => $item->get('CurrentPlayers'),
                    'avg'  => "[0,0,0,0]"
                ]);
            } else {
                $cur = $item->get('CurrentPlayers');
                $min = $today_stats->min;
                $max = $today_stats->max;

                $avg = json_decode($today_stats->avg);

                switch (Carbon::now()->hour) {
                    case 0:
                        $avg[0] = $cur;
                        break;
                    case 6:
                        $avg[1] = $cur;
                        break;
                    case 12:
                        $avg[2] = $cur;
                        break;
                    case 18:
                        $avg[3] = $cur;
                        break;
                }

                $today_stats->update([
                    'min' => $cur < $min ? $cur : $min,
                    'max' => $cur > $max ? $cur : $max,
                    'avg' => json_encode($avg),
                ]);

            }

        } catch (ModelNotFoundException $e) {
            // If server don't event exist lets add them in the list
            event(new UpdateServerEvent($item));
        }
    }
}
