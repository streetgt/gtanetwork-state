<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Stats;
use App\ServerInfo;
use Illuminate\Http\Request;
use App\Http\Requests;

class PageController extends Controller
{
    /**
     * Display the HOME page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.homepage');
    }

    /**
     * Display the FAQ page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        return view('pages.faq');
    }

    /**
     * Display the Player Stats page
     */
    public function stats()
    {
        $today = Stats::where('date', Carbon::today())->first();

        $players = [
            'today_current'              => $players = ServerInfo::sum('currentplayers'),
            'today_min'                  => $today->min,
            'today_max'                  => $today->max,
            'today_avg'                  => round(array_sum(json_decode($today->avg)) / 4),
            'min'                        => Stats::orderBy('min', 'ASC')->pluck('min')->first(),
            'max'                        => Stats::orderBy('max', 'DES')->pluck('max')->first(),
            'total_servers'              => ServerInfo::count(),
            'most_players_online_record' => Stats::all()->max('max'),
        ];

        $stats = Stats::orderBy('date', 'ASC')->get();

        return view('pages.stats', compact('stats', 'players'));
    }

    /**
     * Display the Forum Stats page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forumStats()
    {
        return view('pages.forum-stats');
    }

    /**
     * Display the Natives page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function natives()
    {
        return view('pages.natives');
    }

    /**
     * Display the Bans page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bans()
    {
        return view('pages.bans');
    }
}
