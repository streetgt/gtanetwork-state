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
    private $uriServerList = 'https://master.gtanet.work/apiservers';

    /**
     * @var string
     */
    private $uriVerifiedServerList = 'https://master.gtanet.work/verified';

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
            $response = $this->client->request('GET', $this->uriServerList);
        } catch (ClientException $e) {
            return [];
        } catch (Exception $e) {
            return [];
        }

        $data = json_decode($response->getBody()->getContents());

        return $data->list;
    }

    /**
     * @return array
     */
    public function getVerifiedServersList()
    {
        try {
            $response = $this->client->request('GET', $this->uriVerifiedServerList);
        } catch (ClientException $e) {
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

        foreach ($array_requests as $word) {
            $crawler = Goutte::request('GET', 'http://www.dev-c.com/nativedb/ns/' . $word);
            $ul = $crawler->filter('a[class="fn_trigger"]')->each(function ($node) {
                return $node->text();
            });
            foreach ($ul as $native) {
                if ( ! empty($native)) {

                    $split = explode(' ', $native);
                    $type = $split[0];
                    $name = substr($native, strlen($split[0]) + 1, stripos($native, ')') - strlen($split[0]));
                    if (substr($native, strlen($split[0]) + 1, 1) == '*') {
                        $type = $split[0] . '*';
                        $name = substr($native, strlen($split[0]) + 2, stripos($native, ')') - strlen($split[0]) - 1);
                    }

                    $data = [
                        'category' => $word,
                        'type'     => $type,
                        'name'     => $name,
                        'hash'     => '0x' . substr($native, stripos($native, '//') + 3, strlen($native)),
                    ];

                    if (DB::table('util_natives')->where('hash', $data['hash'])->first() == null) {
                        DB::table('util_natives')->insert($data);
                    }
                }
            }
        }
        //dd($natives);
    }

    /**
     * Fetch the natives directly from ScriptHookV
     * Inserts into the table if it's a new native or update if exists.
     */
    public function getNativesFromFile()
    {
        try {
            $savePath = resource_path() . '/files/natives.h';
            $myFile = fopen($savePath, 'w+') or die('Problems');

            $request = $this->client->request('GET', 'http://www.dev-c.com/nativedb/natives.h', [
                'decode_content' => 'gzip',
                'timeout'        => 10,
                'sink'           => $myFile
            ]);

            $lines = file($savePath);

            $natives = [];
            $current_type = null;
            foreach ($lines as $line_num => $line) {
                $line = preg_replace('~[\r\n\t]+~', '', $line);
                if (preg_match('/namespace/', $line) || preg_match('/static/', $line)) {
                    if (preg_match('/namespace/', $line)) {
                        $current_type = substr($line, 10, strlen($line));
                    } else if (preg_match('/static/', $line)) {
                        $line_array = explode(' ', $line);
                        $size = strlen($line_array[0]) + strlen($line_array[1]) + 2;
                        $data = [
                            'category' => $current_type,
                            'type'     => $line_array[1],
                            'name'     => substr($line, $size, stripos($line, ')') + 1 - strlen($line)),
                            'hash'     => substr($line, stripos($line, '//') + 3, strlen($line))
                        ];

                        $natives[] = $data;

                        $item = DB::table('util_natives')->where('hash', $data['hash'])->first();
                        if ($item == null) {
                            DB::table('util_natives')->insert($data);
                        } else {
                            DB::table('util_natives')->where('id', $item->id)->update($data);
                        }
                    }
                }
            }
            file_put_contents(resource_path() . '/files/natives.json', json_encode($natives));
            exit();
        } catch (ClientException $e) {
            echo $e->getMessage();
        }
    }

    public function restoreNativesFromBackup()
    {
        try {
            DB::table('util_natives')->truncate();

            $lines = file(resource_path() . '/files/natives_backup.h');

            $current_type = null;
            foreach ($lines as $line_num => $line) {
                $line = preg_replace('~[\r\n\t]+~', '', $line);
                if (preg_match('/namespace/', $line) || preg_match('/static/', $line)) {
                    if (preg_match('/namespace/', $line)) {
                        $current_type = substr($line, 10, strlen($line));
                    } else if (preg_match('/static/', $line)) {
                        $line_array = explode(' ', $line);
                        $size = strlen($line_array[0]) + strlen($line_array[1]) + 2;
                        $data = [
                            'category' => $current_type,
                            'type'     => $line_array[1],
                            'name'     => substr($line, $size, stripos($line, ')') + 1 - strlen($line)),
                            'hash'     => substr($line, stripos($line, '//') + 3, strlen($line))
                        ];

                        DB::table('util_natives')->insert($data);
                    }
                }
            }
            exit();
        } catch (ClientException $e) {
            echo $e->getMessage();
        }
    }

    public function getTotalCommits()
    {
        try {
            $response = $this->client->request('GET', env('REPO_URL'), [
                'auth' => [env('REPO_USER'), env('REPO_PASSWORD')]
            ]);

        } catch (ClientException $e) {
            return 0;
        }

        $data = json_decode($response->getBody()->getContents());

        $commits = 0;
        foreach ($data as $item) {
            $commits += $item->total;
        }

        return $commits;
    }

}