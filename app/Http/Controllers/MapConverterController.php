<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Exception;


class MapConverterController extends Controller
{
    private static $GUADMAZ = '0';
    private static $MENYOO = '1';
//    private static $GTANETWORK_INPUT_CS = '2';
//    private static $GTANETWORK_INPUT_XML = '3';

    private static $GTANETWORK_CS = '0';
    private static $GTANETWORK_XML = '1';


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
        $source_type = $request->input('convertion-source');
        $source_output = $request->input('convertion-output');
        $request_xml = $request->input('code-area');
        $request_xml = preg_replace("/\r\n|\r/", " ", $request_xml);

        try {
//            if ($source_type != static::$GTANETWORK_INPUT_CS && $source_type != static::$GTANETWORK_INPUT_XML) {
                $this->validateXML($request_xml);
                $xml = new \SimpleXMLElement($request_xml, null, false);
//            } else {
//                $xml = $request_xml;
//            }

            $this->validateSouceOrigin($xml, $source_type);

        } catch (\Exception $e) {
            return view('pages.map')->withErrors($e->getMessage());
        }

        $code = $this->convertMap($xml, $source_type, $source_output);
        $total = count($code);

        return view('pages.map', compact('code', 'total'));
    }

    private function convertMap($xml, $source_origin, $dest_souce)
    {
        $code = array();

        switch ($source_origin) {
            case static::$GUADMAZ: {
                foreach ($xml->Objects->MapObject as $object) {
                    $data = [
                        'id'       => $object->Hash,
                        'type'     => $object->Type,
                        'position' => array($object->Position->X, $object->Position->Y, $object->Position->Z),
                        'rotation' => array($object->Rotation->X, $object->Rotation->Y, $object->Rotation->Z),
                    ];

                    switch ($object->Type) {
                        case 'Prop': {
                            if ($dest_souce == static::$GTANETWORK_CS) {
                                $line_code = "API.createObject({$data['id']},new Vector3({$data['position'][0]},{$data['position'][1]},{$data['position'][2]}), new Vector3({$data['rotation'][0]},{$data['rotation'][1]},{$data['rotation'][2]}));";
                            } else {
                                $line_code = "<prop model=\"{$data['id']}\" posX=\"{$data['position'][0]}\" posY=\"{$data['position'][1]}\"  posZ=\"{$data['position'][2]})\" rotX=\"{$data['rotation'][0]}\" rotY=\"{$data['rotation'][1]}\" rotZ=\"{$data['rotation'][2]}\" />";
                            }
                            break;
                        }
                        case 'Pickup': {
                            $data['amount'] = $object->Amount;
                            $data['respawn_timer'] = $object->RespawnTimer;
                            if ($dest_souce == static::$GTANETWORK_CS) {
                                $line_code = "API.createObject((PickupHash){$data['id']},new Vector3({$data['position'][0]},{$data['position'][1]},{$data['position'][2]}), new Vector3({$data['rotation'][0]},{$data['rotation'][1]},{$data['rotation'][2]}),{$data['amount']},{$data['respawn_timer']});";
                            } else {
                                $line_code = "<pickup model=\"{$data['id']}\" posX=\"{$data['position'][0]}\" posY=\"{$data['position'][1]}\"  posZ=\"{$data['position'][2]})\" rotX=\"{$data['rotation'][0]}\" rotY=\"{$data['rotation'][1]}\" rotZ=\"{$data['rotation'][2]}\" amount=\"{$data['amount']}\" respawn=\"{$data['respawn_timer']}\" />";
                            }
                            break;
                        }
                    }
                    array_push($code, $line_code);
                }
                break;
            }
            case static::$MENYOO: {
                foreach ($xml->Placement as $object) {
                    $data = [
                        'id'       => hexdec($object->ModelHash),
                        'type'     => $object->Type,
                        'position' => array($object->PositionRotation->X, $object->PositionRotation->Y, $object->PositionRotation->Z),
                        'rotation' => array($object->PositionRotation->Pitch, $object->PositionRotation->Roll, $object->PositionRotation->Yaw),
                    ];

                    switch ($object->Type) {
                        case 2: {
                            $data['color'][0] = $object->VehicleProperties->Colours->Primary;
                            $data['color'][1] = $object->VehicleProperties->Colours->Secondary;
                            if ($dest_souce == static::$GTANETWORK_CS) {
                                $line_code = "API.createVehicle((VehicleHash)({$data['id']}),new Vector3({$data['position'][0]},{$data['position'][1]},{$data['position'][2]}), new Vector3({$data['rotation'][0]},{$data['rotation'][1]},{$data['rotation'][2]}),{$data['color'][0]},{$data['color'][1]});";
                            } else {
                                $line_code = "<vehicle model=\"{$data['id']}\" posX=\"{$data['position'][0]}\" posY=\"{$data['position'][1]}\"  posZ=\"{$data['position'][2]})\" rotX=\"{$data['rotation'][0]}\" rotY=\"{$data['rotation'][1]}\" rotZ=\"{$data['rotation'][2]}\" color1=\"{$data['color'][0]}\" color2=\"{$data['color'][1]}\" />";
                            }
                            break;
                        }
                        case 3: {
                            if ($dest_souce == static::$GTANETWORK_CS) {
                                $line_code = "API.createObject({$data['id']},new Vector3({$data['position'][0]},{$data['position'][1]},{$data['position'][2]}), new Vector3({$data['rotation'][0]},{$data['rotation'][1]},{$data['rotation'][2]}));";
                            } else {
                                $line_code = "<prop model=\"{$data['id']}\" posX=\"{$data['position'][0]}\" posY=\"{$data['position'][1]}\"  posZ=\"{$data['position'][2]})\" rotX=\"{$data['rotation'][0]}\" rotY=\"{$data['rotation'][1]}\" rotZ=\"{$data['rotation'][2]}\" />";
                            }
                            break;
                        }
                    }
                    array_push($code, $line_code);
                }
                break;
            }
        }

        return $code;
    }

    /**
     * Check if a XML string is valid
     *
     * @param $request_xml
     * @throws Exception
     */
    private function validateXML($request_xml)
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($request_xml);
        if ( ! $xml) {
            throw new Exception('The souce code you provided could not be resolved as a valid XML.');
        }
    }

    /**
     * Validade if the source code is a valid map editor xml
     *
     * @param $xml
     * @param $source_origin
     * @throws Exception
     */
    private function validateSouceOrigin($xml, $source_origin)
    {
        switch ($source_origin) {
            case static::$GUADMAZ: {
                if ( ! isset($xml->Objects->MapObject)) {
                    throw new Exception('The souce code you provided is not a valid Guadmaz Map Editor source.');
                }
                break;
            }
            case static::$MENYOO: {
                if ( ! $xml->getName() == 'SpoonerPlacements' && ! isset($xml->Placement)) {
                    throw new Exception('The souce code you provided is not a valid Menyoo Map Editor source.');
                }
                break;
            }
        }
    }

    /**
     * Converts a XML File to Array
     *
     * @param \SimpleXMLElement $parent
     * @return array
     */
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
