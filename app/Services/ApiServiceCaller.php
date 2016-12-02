<?php

namespace App\Services;

use DB;
use Goutte;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
//                 {"Port":4499,"MaxPlayers":6,"ServerName":"Guadmaz Test Server","CurrentPlayers":0,"Gamemode":"freeroam","Map":null,"IP":"46.101.1.92:4499"},
//                 {"Port":4499,"MaxPlayers":50,"ServerName":"FiveRP Test Server","CurrentPlayers":0,"Gamemode":"fiverp","Map":null,"IP":"72.5.195.93:4499"},
//                 {"Port":4499,"MaxPlayers":16,"ServerName":"Layak Test Server","CurrentPlayers":2,"Gamemode":"GTA Network","Map":null,"IP":"178.33.67.117:4499"},
//                 {"Port":4499,"MaxPlayers":20,"ServerName":"Adam\'s Weird Server","CurrentPlayers":0,"Gamemode":"freeroam","Map":null,"IP":"51.254.32.217:4499"}]}';

//        $data = json_decode($response);

        try {
            $response = $this->client->request('GET', $this->uri);
        }
        catch (ClientException $e)
        {
            return [];
        }

        $data = json_decode($response->getBody()->getContents());

        return $data->list;
    }

    public function getNatives()
    {
        $array_requests = [
            "PLAYER",
            "ENTITY",
            "PED",
            "VEHICLE",
            "OBJECT",
            "AI",
            "GAMEPLAY",
            "AUDIO",
            "CUTSCENE",
            "INTERIOR",
            "CAM",
            "WEAPON",
            "ITEMSET",
            "STREAMING",
            "SCRIPT",
            "UI",
            "GRAPHICS",
            "STATS",
            "BRAIN",
            "MOBILE",
            "APP",
            "TIME",
            "PATHFIND",
            "CONTROLS",
            "DATAFILE",
            "FIRE",
            "DECISIONEVENT",
            "ZONE",
            "ROPE",
            "WATER",
            "WORLDPROBE",
            "NETWORK",
            "NETWORKCASH",
            "DLC1",
            "DLC2",
            "SYSTEM",
            "DECORATOR",
            "SOCIALCLUB",
            "UNK",
            "UNK1",
            "UNK2",
            "UNK3"
        ];

        foreach ($array_requests as $word)
        {
            $crawler = Goutte::request('GET', 'http://www.dev-c.com/nativedb/ns/'.$word);
            $ul = $crawler->filter('a[class="fn_trigger"]')->each(function ($node) {
                return $node->text();
            });
            foreach ($ul as $native) {
                if ( ! empty($native)) {

                    $split = explode(' ', $native);
                    $type = $split[0];
                    $name = substr($native, strlen($split[0]) + 1, stripos($native, ')') - strlen($split[0]));
                    if(substr($native, strlen($split[0])+1,1) == '*')
                    {
                        $type = $split[0] .'*';
                        $name = substr($native, strlen($split[0])+2, stripos($native, ')') - strlen($split[0])-1);
                    }

                    $data = [
                        'category' => $word,
                        'type' => $type,
                        'name' => $name,
                        'hash' => '0x' . substr($native, stripos($native, '//') + 3, strlen($native)),
                    ];

                    if(DB::table('util_natives')->where('hash', $data['hash'])->first() == null)
                    {
                        DB::table('util_natives')->insert($data);
                    }
                }
            }
        }
        //dd($natives);
    }

}