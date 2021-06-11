<?php
namespace IAServer\Http\Controllers\Aoicollector\Api\Cuarentena;

use IAServer\Http\Requests;
use Illuminate\Support\Facades\Response;
use IAServer\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

set_time_limit(400);

class ControllerCuarentena extends Controller
{

    public function data() {

        $toResume = new \stdClass();

            $query = DB::table('lanzamientos.lanzamiento_op as t1')
                    ->leftJoin('aoidata.cuarentena as t2', 't1.op','=','t2.op')
                    ->select(DB::raw('max(t1.id) as id_lanzamiento'), 't1.op', 't1.quarantine', DB::raw('max(t2.id) as id_cuarentena'))
                    ->where('t1.arrived', '=', '0')
                    ->where('t1.quarantine', '=', 'true')
                    ->groupBy('t1.op')
                    ->get();

                    if(!empty($query)) {

                        foreach($query as $dataOP)
                        {
                            $data = $this->pointer($dataOP->op, $dataOP->id_cuarentena);

                            $id = $dataOP->id_cuarentena;
                            $toResume->$id = $dataOP->op .' ' .$data;
                           
                        }

                        return Response::json($toResume);

                    } else {

                        return 'Sin OP en cuarentena !';

                    }
    }

    public function pointer($op, $id_cuarentena) {

        $point = DB::table('aoidata.cuarentena_pointer')->select('*')->where('op','=',$op)->get();

        if(!empty($point)) {

            $barcode = $this->barcodes($op, $id_cuarentena, $point[0]->pointer);

            return $barcode;

        } else {

            return 'Sin puntero de inicio: ' .$op;
        }

    }

    public function barcodes($op, $id_cuarentena, $date) {

        $fecha = '';
        $hora = '';

        $inspection = new FindInspeccion();

        $data = $inspection->inspectionBloque($op, $date);


            if(!empty($data)) {


                if($data[0]->etiqueta === "E") {

                $total = count($data);

                foreach($data as $barcode)
                {

                    $inspection->inspectionPrimary($id_cuarentena, $barcode->barcode);

                }
                    // finalizado el ciclo actualiza puntero
                $pointer = $this->updatePointer($op, $barcode->dateTime);

                return 'Procesadas correctamente: ' .$total .' ' .$pointer;


                } else if ($data[0]->etiqueta === "V") {

                    $secon = $inspection->inspectionPanel($op, $date);

                    $total = count($secon);

                    foreach($secon as $barcode)
                    {

                        $inspection->inspectionPrimary($id_cuarentena, $barcode->panel_barcode);

                    }

                    // finalizado el ciclo actualiza puntero
                    $pointer = $this->updatePointer($op, $barcode->dateTime);

                    return 'Procesadas correctamente: ' .$total .' ' .$pointer;

                }

            } else {

                return 'no se ah detentado informacion de la : ' .$op;

            }

    }

    public function updatePointer($op, $dateTime) {

        $fecha = Carbon::now();
        $date = $fecha->format('Y-m-d');
        $time = $fecha->format('h:i:s');

        $query = DB::table('aoidata.cuarentena_pointer')
                    ->where('op','=',$op)
                    ->update([
                            'date'   => $date,
                            'time'   => $time,
                            'pointer' => $dateTime
                        ]);

        return '( Pointer actualizado: ' .$dateTime .')';

    }

}