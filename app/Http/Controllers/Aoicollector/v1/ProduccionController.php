<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Aoicollector\v1\ProduccionController;
use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Aoicollector\Model\Panel;
use App\Http\Controllers\Aoicollector\Model\Produccion;
use App\Http\Controllers\Aoicollector\Model\Stocker;
use App\Http\Controllers\Aoicollector\Model\StockerTraza;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Smtdatabase;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public static function vista()
    {
        return Produccion::from("vi_production");
    }

    public static function maquina($id_maquina)
    {
        return self::vista()->where('id_maquina', $id_maquina)->first();
    }

    public static function barcode($barcode)
    {
        return self::vista()->where('barcode', $barcode)->first();
    }

    public static function allBarcode()
    {
        return self::vista()->orderBy('linea','asc')->get();
    }

    public static function byLine($linenumber)
    {
        return self::vista()->where('numero_linea',$linenumber )->get();
    }

    /**
     * Obtiene datos de configuracion de produccion, rutas de SFCS, declara o no, OP, Estado de OP en WIP
     *
     * @param string $aoibarcode
     * @param bool $withWipTransaction
     * @return array
     */
    public static function fullInfo(Request $req, $aoibarcode,
        $options = array(
            'wip' => true,
            'smt' => true,
            'smtroute' => true,
            'sfcsroute' => true,
            'stocker' => true,
            'placas' => true,
            'transaction' => true,
            'inspector' => true,
            'period' => true,
            'allstocker' => false
        )
    )
    {
        $default_options = array(
            'wip' => true,
            'smt' => true,
            'smtroute' => true,
            'sfcsroute' => true,
            'stocker' => true,
            'placas' => true,
            'transaction' => true,
            'inspector' => true,
            'period' => true,
            'allstocker' => false
        );

        // En caso de no definir las opciones, se toman las opciones por defecto
        $option = array_merge($default_options, $options);

        // Si obtengo clave filter en el request, se sobreescriben los valores por defecto
        if($req->input('filter'))
        {
            $request_options = array();
            foreach($req->input() as $filterName => $filterValue)
            {
                $request_options[$filterName] = (bool) $filterValue;
            }
            $option = array_merge( $option,$request_options);
        }

        $option = (object) $option;

        $error = null;
        $mode = null;
        if (is_numeric($aoibarcode)) {
            $produccion = ProduccionController::byLine($aoibarcode);
            $mode = 'byLine';
        } else {
            dd("por aca", $aoibarcode);
            $produccion = ProduccionController::barcode($aoibarcode);
            $mode = 'barcode';
        }

        if(isset($produccion->barcode))
        {
            $forProduccion[] = $produccion;
            $produccion = collect($forProduccion);
        }

        // Se solicita informacion de linea, tiene mas de una AOI
        if (count($produccion) > 0) {
            foreach ($produccion as $prod) {
                // Adhiero informacion de inspector asignado a la linea
                if ($option->inspector) {
                    $inspector = self::getInspectorInfo($prod->id_user);

                    $prod->inspector = $inspector;
                }

                $inspected = self::getAllInspectedOpByMachine($prod->id_maquina);

                // Adhiero informacion de SMT y control de placas
                if ($option->smt) {
                    $inspected = self::addSmtToAllInspectedOpByMachine($inspected, $option->placas);

                    if(isset($prod->op))
                    {
                        $locateInspectedOpInfo = $inspected->where('inspected_op',$prod->op);
                        if(count($locateInspectedOpInfo )>0)
                        {
                            $prod->smt = $locateInspectedOpInfo->first()->smt;
                            $prod->controldeplacas = $locateInspectedOpInfo->first()->controldeplacas;
                        } else
                        {
                            $smt = Smtdatabase::findOp($prod->op);

                            if (isset($smt->modelo)) {
                                $smt->registros = Panel::where('inspected_op', $prod->op)->count();

                                $div = $smt->qty;
                                if ($div == 0) {
                                    $div = 1;
                                }
                                $smt->porcentaje = number_format((($smt->prod_aoi / $div) * 100), 1, '.', '');
                                $smt->restantes = $smt->prod_aoi - $smt->qty;
                                $prod->smt = $smt;
                                $prod->controldeplacas = DatosController::salidaByOp($prod->op);
                            }
                        }
                    }
                }

                if (isset($prod->op)) {
                    if($option->wip)
                    {
                        $w = new Wip();
                        $wip = $w->findOp($prod->op, $option->transaction);

                        $prod->wip = $wip;
                    }

                    // Adhiero informacion de ROUTA IASERVER
                    $prod->route = RouteOp::where('id',$prod->id_route_op)->first();

                    // Adhiero informacion de SFCS
                    if ($option->sfcsroute) {

                        if($prod->line_id != null && $prod->modelo_id != null && $prod->puesto_id != null)
                        {
                            // DEPRECAR
                            // $sf = new Sfcs();
                            // $sfcs = $sf->declareMode($prod->op, $prod->line_id, $prod->modelo_id, $prod->puesto_id);
                            // $prod->sfcs = $sfcs;
                        } else {
                            $prod->sfcs = ['error'=>'Faltan datos'];

                            //Lleno los campos del puesto de sfcs para que no falle la consulta en AOICollector
                            $prod->line_id = 0;
                            $prod->puesto_id = 0;
                            $prod->modelo_id = 0;
                        }
                    }

                    // Adhiero informacion de stockers
                    $stkctrl = new TrazaStocker();
                    if ($option->stocker) {
                        $stkctrl = new TrazaStocker();
                        $prod->stocker = $stkctrl->stockerInfoById($prod->id_stocker);
                    }

                    // Adhiero todos los stockers asignados a esa OP
                    if ($option->allstocker) {
                        $allstocker = Stocker::where('op', $prod->op)->get();

                        $stockerList = [];

                        if (count($allstocker) > 0) {
                            foreach ($allstocker as $stk) {
                                $stkctrl = new TrazaStocker();
                                $stockerList[] = $stkctrl->stockerInfoById($stk->id);
                            }
                        }

                        $prod->allstocker = $stockerList;
                    }

                    // Arhiero informacion de periodo de inspecciones
                    if ($option->period && $prod->id_maquina != null) {
                        $period = PanelHistory::periodFirstApparation($prod->id_maquina, 'MIN')->get();

                        $prod->period = $period;
                    }

                } else {
                    $error = "No existe configuracion de OP para esta maquina";
                }

                if($mode=='barcode')
                {
                    $produccion = $produccion->first();
                }

                $output = compact('error', 'inspected', 'produccion');
            }

        } else {
            $error = 'No hay resultados';
            $output = compact('error');
        }

        return $output;
    }

    public static function partialInfo($aoibarcode)
    {
        $default_options = array(
            'wip' => false,
            'smt' => false,
            'smtroute' => true,
            'sfcsroute' => true,
            'stocker' => false,
            'placas' => false,
            'transaction' => false,
            'inspector' => false,
            'period' => false,
            'allstocker' => false
        );


        $option = (object) $default_options;

        if (is_numeric($aoibarcode)) {
            $produccion = Produccion::byLine($aoibarcode);
            $mode = 'byLine';
        } else {
            $produccion = Produccion::barcode($aoibarcode);
            $mode = 'barcode';
        }

//        if(isset($produccion->barcode))
//        {
//            $forProduccion = $produccion;
//            $produccion = collect($forProduccion);
//        }


        if (count($produccion) > 0) {
//            foreach ($produccion as $prod) {
                if ($option->smtroute) {
                    // Adhiero informacion de RUTA IASERVER
                    $produccion->route = RouteOp::where('id',$produccion->id_route_op)->first();

                    // Adhiero informacion de SFCS
                    if ($option->sfcsroute) {

                        if($produccion->line_id != null && $produccion->modelo_id != null && $produccion->puesto_id != null)
                        {
                            $sf = new Sfcs();
                            $sfcs = $sf->declareMode($produccion->op, $produccion->line_id, $produccion->modelo_id, $produccion->puesto_id);
                            $produccion->sfcs = $sfcs;
                        } else {
                            $produccion->sfcs = ['error'=>'Faltan datos'];
                        }
                    }
//                }
                $output = compact('error','produccion');
            }

        }
        return $output;
    }


    public static function getInspectorInfo($id_user)
    {
        $inspector = null;

        if(isset($id_user))
        {
            $inspector = User::find($id_user);
            if ($inspector->hasProfile()) {
                $inspector->fullname = $inspector->profile->fullname();
            } else
            {
                $inspector->fullname = $inspector->name;
            }
        }

        return $inspector;
    }

    public static function getAllInspectedOpByMachine($id_maquina)
    {
        $sql = PanelHistory::select(DB::raw('
            `inspected_op`,
            MIN(`created_time`) as first_inspection,
            MAX(`created_time`) as last_inspection
            '))
            ->where('id_maquina',$id_maquina)
            ->whereRaw(DB::raw('created_date = CURDATE() '))
            ->groupBy('inspected_op');

        return $sql->get();
    }

    public static function addSmtToAllInspectedOpByMachine(Collection $inspected)
    {
        foreach($inspected as $insop)
        {
            $smt = SMTDatabase::findOp($insop->inspected_op);

            if (isset($smt->modelo)) {
                $smt->registros = Panel::where('inspected_op', $insop->inspected_op)->count();

                $div = $smt->qty;
                if ($div == 0) {
                    $div = 1;
                }
                $smt->porcentaje = number_format((($smt->prod_aoi / $div) * 100), 1, '.', '');
                $smt->restantes = $smt->prod_aoi - $smt->qty;
                $insop->smt = $smt;
                $insop->controldeplacas = DatosController::salidaByOp($insop->inspected_op);
            }
        }

        return $inspected;
    }
}