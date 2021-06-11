<?php
namespace IAServer\Http\Controllers\Aoicollector\Api\CollectorClient;

use IAServer\Events\AoicollectorEventInspection;
use IAServer\Http\Requests;
use IAServer\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class CollectorClientEventApi extends Controller
{
    public function Inspection($panelBarcode) {

        Event::fire(new AoicollectorEventInspection($panelBarcode));

        $panel = $panelBarcode;

        $output = compact('panel');
        return $output;
    }
}
