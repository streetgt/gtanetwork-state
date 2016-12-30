<?php

namespace App\Http\Controllers\API;

use App\Ban;
use Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    /**
     * Returns a list in JSON of Internet Servers
     *
     * @return mixed
     */
    public function index()
    {
        return response()->json(Ban::all());
    }

    public function show($social_club)
    {
        $ban = Ban::where('social_club', $social_club)->first();

        if ($ban == null) {
            return response()->json([
                'status'  => 400,
                'message' => 'Social Club player is not banned',
            ]);
        }

        return response()->json($ban);
    }

    public function store(Request $request)
    {
        $banned_by = DB::table('bans_tokens')->where('token', $request->input('token'))->first();

        if ($banned_by == null) {
            return response()->json([
                'status'  => 402,
                'message' => 'Unauthorized access!',
            ]);
        }

        $ban = Ban::create($request->all());

        return response()->json($ban);
    }

    /**
     * Returns a list in JSON of Internet Servers
     *
     * @return mixed
     */
    public function datatable()
    {
        return Datatables::of(Ban::all())->make(true);
    }
}
