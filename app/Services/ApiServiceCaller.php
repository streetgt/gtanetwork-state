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
        $response = $this->client->request('GET',$this->uri);

        $data = json_decode($response->getBody()->getContents());

        return $data->list;
    }

}