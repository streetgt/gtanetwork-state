<?php

namespace App\Listeners;

use GuzzleHttp\Client;
use App\Server;
use App\Events\UpdateServerEvent;
use App\Events\UpdateServerStatisticsEvent;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateServerList implements ShouldQueue
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Server
     */
    private $server;

    /**
     * UpdateServerList constructor.
     * @param Client $client
     * @param Server $server
     */
    public function __construct(Client $client, Server $server)
    {
        $this->client = $client;
        $this->server = $server;
    }

    /**
     * Handle the event.
     *
     * @param  UpdateServerEvent $event
     * @return void
     */
    public function handle(UpdateServerEvent $event)
    {
        $element = $event->server;

        try {

            Server::updateOrCreate([
                'ip'         => $element->get('IP'),
                'port'       => $element->get('Port'),
                'servername' => $element->get('ServerName'),
                'gamemode'   => $element->get('Gamemode'),
                'map'        => $element->get('Map'),
                'country'    => $this->getCountry($element->get('IP')),
            ]);

            event(new UpdateServerStatisticsEvent($element));

            event(new UpdateServerInfoEvent($element));

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            // Already exists the server IP
            if ($errorCode == 1062) {
                Server::where('ip', $element->get('IP'))->update([
                    'ip'         => $element->get('IP'),
                    'port'       => $element->get('Port'),
                    'servername' => $element->get('ServerName'),
                    'gamemode'   => $element->get('Gamemode'),
                    'map'        => $element->get('Map'),
                    'country'    => $this->getCountry($element->get('IP')),
                ]);

                event(new UpdateServerStatistics($element));
            }
        }
    }

    /**
     * Gets the country from a IP given
     *
     * @param $ip
     * @return mixed
     */
    private function getCountry($ip)
    {
        $split = explode(':', $ip);
        $res = $this->client->request('GET', 'https://ipinfo.io/' . $split[0] . '/country');

        return trim(preg_replace("/\r\n|\r|\n/", ' ', $res->getBody()->getContents()));
    }
}
