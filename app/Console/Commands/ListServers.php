<?php

namespace App\Console\Commands;

use DB;
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
}
