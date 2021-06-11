<?php
namespace IAServer\Http\Controllers\Aoicollector\Api\Cuarentena;

use IAServer\Http\Requests;
use Illuminate\Support\Facades\Response;
use IAServer\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleHttpClient;

set_time_limit(400);

class FindInspeccion extends Controller
{

    function inspectionBloque($op, $date) {

        $query = DB::table('aoidata.history_inspeccion_panel as t1')
        ->join('aoidata.history_inspeccion_bloque as t2', 't1.id_panel_history', '=', 't2.id_panel_history')
        ->select('t2.barcode','t2.etiqueta','t1.dateTime')
        ->where('t1.inspected_op','=', $op)
        ->where('t1.modo', '=', 'insert')
        ->where('t1.dateTime', '>=', $date)
        ->get();

        return $query;

    }

    function inspectionPanel($op, $date) {

        $query = DB::table('aoidata.history_inspeccion_panel')
        ->select('panel_barcode','dateTime')
        ->where('inspected_op','=', $op)
        ->where('modo', '=', 'insert')
        ->where('dateTime', '>=', $date)
        ->get();

        return $query;

    }

    public function inspectionPrimary($id_cuarentena, $barcode) {

        $fecha = '';
        $hora = '';

        $ex = DB::table('aoidata.cuarentena_detalle')->select('*')
        ->where('id_cuarentena','=', $id_cuarentena)->where('barcode','=', $barcode)
        ->get();

        if(empty($ex)) {

            $fecha = Carbon::now();
            $dateFull = $fecha->format('Y-m-d h:i:s');

            $query = DB::table('aoidata.cuarentena_detalle')
                        ->insert([
                                'id_cuarentena'   => $id_cuarentena,
                                'barcode'         => $barcode,
                                'created_at'      => $dateFull,
                                'updated_at'      => $dateFull,
                                'released_at'     => null
                                ]);

            return 'insert';

        } else {

            return 'exists';
        }
    }

}