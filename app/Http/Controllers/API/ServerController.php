<?php

namespace App\Http\Controllers\API;

use App\Server;
use Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{
    /**
     * @return mixed
     */
    public function listServers()
    {
        $servers = Server::leftJoin('players_online', 'players_online.server_id', '=', 'servers.id')->select('servers.*', 'players_online.currentplayers as currentplayers','players_online.maxplayers as maxplayers');

        return Datatables::of($servers)->make(true);
    }
}
