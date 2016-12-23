<?php

namespace App\Console\Commands;

use DB;
use App\Stats;
use App\ServerInfo;
use Carbon\Carbon;
use App\Events\UpdateServerEvent;
use App\Events\UpdateServerInfoEvent;
use App\Events\UpdateServerStatisticsEvent;
use App\Services\ApiServiceCaller;
use Illuminate\Console\Command;

class ListServers extends Command
{
    /**
     * @var
     */
    private $api;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gtanetwork:list {option=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the current Server List';

    /**
     * ListServers constructor.
     * @param ApiServiceCaller $service
     */
    public function __construct(ApiServiceCaller $service)
    {
        $this->api = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = $this->argument('option');
        $servers = $this->api->getServerList();

        if ($option == 2) {
            $this->updateOldServersInfo($servers);
            $this->updateTodayStats();
        } else if ($option == 0) {
            $this->deleteOldServers();
        }

        if (empty($servers)) {
            return;
        }

        foreach ($servers as $server) {
            $collection = collect($server);
            switch ($option) {
                case 0:
                    event(new UpdateServerEvent($collection));
                    break;
                case 1:
                    event(new UpdateServerStatisticsEvent($collection));
                    break;
                case 2:
                    event(new UpdateServerInfoEvent($collection));
                    break;
                case 3:
                    $this->api->getNatives();
                    break;
                default:
                    event(new UpdateServerEvent($collection));
                    break;
            }
        }
    }

    /**
     *  Update servers that are not yet updated
     *
     * @param $servers
     * @return array
     */
    private function updateOldServersInfo($servers)
    {
        $updated = [];
        foreach ($servers as $server) {
            $id = DB::table('servers')->where('ip', $server->IP)->pluck('id')->first();
            if ($id != null) {
                $updated[] = $id;
            }
        }

        DB::table('server_info')
            ->whereNotIn('server_id', array_values($updated))
            ->update(['currentplayers' => 0]);
    }

    /**
     * Delete old servers that are not listed
     */
    private function deleteOldServers()
    {
        $servers = DB::table('server_info')->where('updated_at', '<=', Carbon::now()->subHours(2))->pluck('server_id')->toArray();
        DB::table('servers')->whereIn('id', array_values($servers))->delete();
    }

    /**
     * Updates the stats from today online servers
     */
    private function updateTodayStats()
    {
        $today_stats = Stats::where('date', Carbon::today('Europe/Lisbon'))->first();

        $current_players = (int) ServerInfo::sum('currentplayers');

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
                    $avg[0] < $current_players ? $avg[0] = $current_players : $avg[0];
                    break;
                case 6:
                    $avg[1] < $current_players ? $avg[1] = $current_players : $avg[1];
                    break;
                case 12:
                    $avg[2] < $current_players ? $avg[2] = $current_players : $avg[2];
                    break;
                case 18:
                    $avg[3] < $current_players ? $avg[3] = $current_players : $avg[3];
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
