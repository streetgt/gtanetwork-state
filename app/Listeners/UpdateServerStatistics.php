<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Server;
use App\Events\UpdateServerStatisticsEvent;
use App\Events\UpdateServerEvent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateServerStatistics implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  UpdateServerStatisticsEvent $event
     * @return void
     */
    public function handle(UpdateServerStatisticsEvent $event)
    {
        $item = $event->server;

        $server = Server::where('ip', $item->get('IP'))->first();

        if($server == null) {
            event(new UpdateServerEvent($item));
            return;
        }

        $timestamp = Carbon::now();

        // Check if there is already a relationship
        if ($server->statistics()->count()) {
            $stats = $server->statistics;

            $highest_peak = $stats->highest_peak;
            if ($highest_peak < $item->get('CurrentPlayers')) {
                $highest_peak = $item->get('CurrentPlayers');
            }

            $daily_stats = json_decode($stats->daily_stats);
            for ($i = 0; $i < 24; $i++) {
                if ($timestamp->hour == $i) {
                    $daily_stats[$i] = $item->get('CurrentPlayers');
                }
            }
            $daily_stats = json_encode($daily_stats);

            $server->statistics->update([
                'daily_stats'  => $daily_stats,
                'highest_peak' => $highest_peak,
            ]);

        } else {

            $highest_peak = $item->get('CurrentPlayers');

            for ($i = 0; $i < 24; $i++) {
                $daily_stats[$i] = 0;
                if ($timestamp->hour == $i) {
                    $daily_stats[$i] = $item->get('CurrentPlayers');
                }
            }
            $daily_stats = json_encode($daily_stats);

            $row = $server->statistics()->create([
                'daily_stats'  => $daily_stats,
                'highest_peak' => $highest_peak,
            ]);
            $server->server_statistics_id = $row->id;
            $server->save();
        }
    }
}
