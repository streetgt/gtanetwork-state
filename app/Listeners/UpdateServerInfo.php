<?php

namespace App\Listeners;

use App\Stats;
use App\Server;
use App\ServerInfo;
use App\Events\UpdateServerInfoEvent;
use Carbon\Carbon;
use Dompdf\Exception;
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

        $this->updateTodayStats();

        try {

            $server = Server::where('ip', $item->get('IP'))->first();

            if($server == null) {
                event(new UpdateServerEvent($item));
                return;
            }

            array_push($servers_id, $server->id);

            $data = [
                'currentplayers' => $item->get('CurrentPlayers'),
                'maxplayers'     => $item->get('MaxPlayers'),
                'passworded'     => $item->get('Passworded')
            ];

            if ($server->info()->count()) {
                $server->info()->update($data);
            } else {
                $row = $server->info()->create($data);
                $server->server_players_online_id = $row->id;
                $server->save();
            }

        } catch (Exception $e) {
            // If server don't event exist lets add them in the list
            dd('Crashed: ' . $e->getMessage());
        }
    }

    /**
     * Updates the stats from today online servers
     */
    private function updateTodayStats()
    {
        $today_stats = Stats::where('date', Carbon::today('Europe/Lisbon'))->first();

        $current_players = ServerInfo::sum('currentplayers');

        if ($today_stats == null) {
            Stats::create([
                'date' => Carbon::today('Europe/Lisbon'),
                'min'  => $current_players,
                'max'  => $current_players,
                'avg'  => "[0,0,0,0]"
            ]);
        } else {

            $min = $today_stats->min;
            $max = $today_stats->max;
            $avg = json_decode($today_stats->avg);

            switch (Carbon::now('Europe/Lisbon')->hour) {
                case 0:
                    $avg[0] < $current_players ? $current_players : $avg[0];
                    break;
                case 6:
                    $avg[1] < $current_players ? $current_players : $avg[1];
                    break;
                case 12:
                    $avg[2] < $current_players ? $current_players : $avg[2];
                    break;
                case 18:
                    $avg[3] < $current_players ? $current_players : $avg[3];
                    break;
            }

            $today_stats->update([
                'min' => $current_players < $min ? $current_players : $min,
                'max' => $current_players > $max ? $current_players : $max,
                'avg' => json_encode($avg),
            ]);

        }
    }
}
