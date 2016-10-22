<?php

namespace App\Console\Commands;

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
                default:
                    event(new UpdateServerEvent($collection));
                    break;
            }
        }
    }
}
