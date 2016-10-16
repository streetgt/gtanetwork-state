<?php

namespace App\Http\Controllers;

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

}
