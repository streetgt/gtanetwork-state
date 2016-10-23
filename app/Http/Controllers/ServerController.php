<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Image;
use App\Server;
use App\Services\ApiServiceCaller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;

class ServerController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function banner($ip, $color1 = 'FFFFFF', $color2 = 'FFFFFF', $color3 = '000000', $color4 = 'FFFFFF')
    {
        $server = Server::where('ip', $ip)->first();

        if ($server == null) {
            return "server not found";
        }

        $slots = $server->info->maxplayers;
        $currentPlayers = $server->info->currentplayers;

        $font_url = public_path() . '/fonts/visitor2.ttf';

        // create Image from file
        $img = Image::canvas(350, 20, '#' . $color3);

        //Border
        $img->rectangle(0, 0, 349, 19, function ($draw) {
            $draw->border(1, '#000000');
        });

        //Type
        $img->rectangle(1, 1, 348, 9, function ($draw) {
            $draw->background('#343634');
        });

        //TEXT
        $img->text($server->servername, 35, 8, function ($font) use ($font_url, $color1) {
            $font->file($font_url);
            $font->size(13);
            $font->color('#' . $color1);
        });

        $img->text($server->ip, 35, 16, function ($font) use ($font_url, $color1) {
            $font->file($font_url);
            $font->size(13);
            $font->color('#' . $color1);
        });

        $img->text($currentPlayers . '/' . $slots, 142, 16, function ($font) use ($font_url, $color1) {
            $font->file($font_url);
            $font->size(13);
            $font->color('#' . $color1);
        });

        $img->text($server->gamemode, 185, 16, function ($font) use ($font_url, $color1) {
            $font->file($font_url);
            $font->size(13);
            $font->color('#' . $color1);
        });

        //GRAPHIC
        $img->rectangle(268, 18, 324, 2, function ($draw) {
            $draw->border(1, '#FFF');
        });

        $daily_stats = json_decode($server->statistics->daily_stats);

        $per_hour = 2;

        $last = [269 + $per_hour, 17, 269 + $per_hour, 3];
        foreach (array_reverse($daily_stats) as $key => $day) {

            $last[0] += $per_hour;
            $last[2] += $per_hour;

            $number = 17;
            if ($day == $slots) {
                $number = 3;
            } else if ($day > 0) {
                $number = $this->map($day, 0, $slots, 3, 17);
            }
            $img->line($last[0], $number, $last[2], 17, function ($draw) use ($color2) {
                $draw->color('#' . $color2);
            });

        }
        //END GRAPHIC

        // GTA Network - Logotipo
        $gtan_url = public_path() . '/images/logo.png';
        $gtan = Image::make($gtan_url);
        $gtan->resize(14, 14);
        $img->insert($gtan, 'left', 10, 10);

        // Country Flag
        $flag_url = public_path() . '/images/flags/18x12/' . strtolower($server->country) . '.gif';
        $fag = Image::make($flag_url);
//        $fag->resize(14, 14);
        $img->insert($fag, 'right', 3, 10);

        $response = Response::make($img->encode('png'));

        $response->header('Content-Type', 'image/png');

        return $response;
    }

    /**
     * Search POST
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postSearch(Request $request)
    {
        $server = Server::where('ip', $request->input('ip'))->first();

        if ($server == null) {
            return redirect()->route('homepage')->withErrors('The server you are trying to find does not exist.');
        }

        return redirect()->route('server.getSearch', $request->input('ip'));
    }

    /**
     * Search GET
     *
     * @param null $server_ip
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSearch($server_ip = null)
    {
        $server = Server::where('ip', $server_ip)->first();

        if ($server == null) {
            return redirect()->route('homepage')->withErrors('The server you are trying to find does not exist.');
        }

        $statistics = $server->statistics;
        $playersOnline = $server->info;

        return view('servers.information', compact('server', 'statistics', 'playersOnline'));
    }

    /**
     * Function to map
     *
     * @param $x
     * @param $in_min
     * @param $in_max
     * @param $out_min
     * @param $out_max
     * @return float|int
     */
    private function map($x, $in_min, $in_max, $out_min, $out_max)
    {
        return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
    }
}
