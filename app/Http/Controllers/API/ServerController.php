<?php

namespace App\Http\Controllers\API;

use DB;
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
        $servers = Server::leftJoin('server_info', 'server_info.server_id', '=', 'servers.id')
            ->select('servers.*',
                'server_info.currentplayers as currentplayers',
                'server_info.maxplayers as maxplayers',
                'server_info.passworded as passworded');

        return Datatables::of($servers)->make(true);
    }

    /**
     * @return mixed
     */
    public function listNatives()
    {
        $natives = DB::table('util_natives');

        return Datatables::of($natives)->make(true);
    }
}
