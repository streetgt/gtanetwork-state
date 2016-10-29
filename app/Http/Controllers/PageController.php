<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Stats;
use App\ServerInfo;
use Dompdf\Exception;
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
            'today_current' => $players = ServerInfo::sum('currentplayers'),
            'today_min'     => $today->min,
            'today_max'     => $today->max,
            'today_avg'     => round(array_sum(json_decode($today->avg)) / 4),
            'min'           => Stats::orderBy('min', 'ASC')->pluck('min')->first(),
            'max'           => Stats::orderBy('max', 'DES')->pluck('max')->first()
        ];

        $stats = Stats::orderBy('date', 'ASC')->get();

        return view('pages.stats', compact('stats', 'players'));
    }

    /**
     * Display the FAQ page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function servers()
    {
        return view('pages.servers');
    }

    /**
     * Display the Map Converter page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMap()
    {
        return view('pages.map');
    }

    /**
     * Display the result from a Map Converter
     *
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postMap(Request $request)
    {
        $request_xml = $request->input('code-area');
        $request_xml = preg_replace("/\r\n|\r/", " ", $request_xml);

        try {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($request_xml);
            if ( ! $xml) {
                throw new Exception('The souce code you provided could not be resolved as a valid XML.');
            }
            $xml = new \SimpleXMLElement($request_xml, null, false);
        } catch (Exception $e) {
            return view('pages.map')->withErrors($e->getMessage());
        }
        $code = array();
        foreach ($xml->Objects->MapObject as $object) {
            if ($xml->Objects->MapObject->Type == 'Prop') {
                array_push($code, array(
                    'id'       => $object->Hash,
                    'position' => array($object->Position->X, $object->Position->Y, $object->Position->Z),
                    'rotation' => array($object->Rotation->X, $object->Rotation->Y, $object->Rotation->Z),
                ));
            }
        }

        return view('pages.map', compact('code'));
    }

    private function XML2Array(\SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = &$array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = &$node[];

            $node = $element->count() ? $this->XML2Array($element) : trim($element);
        }

        return $array;
    }
}
