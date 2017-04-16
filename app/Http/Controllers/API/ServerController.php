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
     * Returns a list in JSON of Internet Servers
     *
     * @return mixed
     */
    public function listInternetServers()
    {
        $servers = Server::join('server_info', 'server_info.server_id', '=', 'servers.id')
            ->select('servers.*',
                'server_info.currentplayers as currentplayers',
                'server_info.maxplayers as maxplayers',
                'server_info.passworded as passworded')
            ->groupBy('id');

        return Datatables::of($servers)->make(true);
    }

    /**
     * Returns a list in JSON of Verified Servers
     *
     * @return mixed
     */
    public function listVerifiedServers()
    {
        $servers = Server::join('server_info', 'server_info.server_id', '=', 'servers.id')
            ->join('servers_verified', 'servers_verified.ip', '=', 'servers.ip')
            ->select('servers.*',
                'server_info.currentplayers as currentplayers',
                'server_info.maxplayers as maxplayers',
                'server_info.passworded as passworded',
                'servers_verified.website as website')
            ->groupBy('id');

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
