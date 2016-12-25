<?php

namespace App\Listeners;

use GuzzleHttp\Client;
use App\Server;
use App\Events\UpdateServerEvent;
use App\Events\UpdateServerInfoEvent;
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

        $server = Server::where('ip', $element->get('IP'))->first();

        if($server == null) {
            Server::create([
                'ip'         => $element->get('IP'),
                'port'       => $element->get('Port'),
                'servername' => $element->get('ServerName'),
                'gamemode'   => $element->get('Gamemode'),
                'map'        => $element->get('Map'),
                'country'    => $this->getCountry($element->get('IP')),
            ]);

            event(new UpdateServerStatisticsEvent($element));

            event(new UpdateServerInfoEvent($element));
        } else {
            $server->update([
                'ip'         => $element->get('IP'),
                'port'       => $element->get('Port'),
                'servername' => $element->get('ServerName'),
                'gamemode'   => $element->get('Gamemode'),
                'map'        => $element->get('Map'),
                'country'    => $this->getCountry($element->get('IP')),
            ]);

            event(new UpdateServerStatisticsEvent($element));
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
        try {
            $res = $this->client->request('GET', 'http://freegeoip.net/json/' . $split[0]);
            $country = json_decode($res->getBody()->getContents())->country_code;
            return trim(preg_replace("/\r\n|\r|\n/", ' ', $country));
        }
        catch (ClientException $e2)
        {
            return 'FR';
        }
    }
}
