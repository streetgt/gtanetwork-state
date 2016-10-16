<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiServiceCaller
{

    /**
     * @var
     */
    private $client;

    /**
     * @var string
     */
    private $uri = 'https://master.gtanet.work/apiservers';

    /**
     * ApiServiceCaller constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @return mixed
     */
    public function getServerList()
    {
//        $response = '{"list":[
//                {"Port":4499,"MaxPlayers":6,"ServerName":"Guadmaz Test Server","CurrentPlayers":0,"Gamemode":"freeroam","Map":null,"IP":"46.101.1.92:4499"},
//                {"Port":4499,"MaxPlayers":50,"ServerName":"FiveRP Test Server","CurrentPlayers":0,"Gamemode":"fiverp","Map":null,"IP":"72.5.195.93:4499"},
//                {"Port":4499,"MaxPlayers":16,"ServerName":"Layak Test Server","CurrentPlayers":2,"Gamemode":"GTA Network","Map":null,"IP":"178.33.67.117:4499"},
//                {"Port":4499,"MaxPlayers":20,"ServerName":"Adam\'s Weird Server","CurrentPlayers":0,"Gamemode":"freeroam","Map":null,"IP":"51.254.32.217:4499"},
//                {"Port":4499,"MaxPlayers":20,"ServerName":"Gomitung\'s Test Server(Somos grandes!)","CurrentPlayers":0,"Gamemode":"GTA Network","Map":null,"IP":"95.95.28.67:4499"}]}';
//        $data = json_decode($response);

        $response = $this->client->request('GET',$this->uri);

        $data = json_decode($response->getBody()->getContents());

        return $data->list;
    }

}