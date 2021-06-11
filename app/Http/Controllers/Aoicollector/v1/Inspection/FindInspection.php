<?php

namespace App\Http\Controllers\Aoicollector\v1\Inspection;

use App\Http\Controllers\Aoicollector\v1\BloqueController;
use App\Http\Controllers\Aoicollector\v1\PanelController;
use App\Http\Controllers\Aoicollector\v1\BloqueHistoryController;
use App\Http\Controllers\Aoicollector\v1\PanelHistoryController;
use App\Http\Controllers\Aoicollector\v1\Cuarentena\CuarentenaController;
use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Aoicollector\Model\BloqueHistory;
use App\Http\Controllers\Aoicollector\Model\Maquina;
use App\Http\Controllers\Aoicollector\Model\Panel;
use App\Http\Controllers\Aoicollector\Model\PanelHistory;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;

class FindInspection extends Controller
{
    /**
     * @var bool Verifica si la placa se encuentra en TransaccionesWip y adjunta el resultado
     */
    public $withWip = false;
    /**
     * @var bool
     */
    public $withDetail = false;
    /**
     * @var bool
     */
    public $withProductioninfo = false;
    /**
     * @var bool Adjunta informacion de SMT relacionada a la OP de la inspeccion
     */
    public $withSmt = false;
    /**
     * @var bool Adjunta trazabilidad de Cogiscan
     */
    public $withCogiscan = false;
    /**
     * @var bool Devuelve solo la ultima inspeccion de la placa
     */
    public $onlyLast = false;
    /**
     * @var bool Adjunta el historial de inspecciones de la placa
     */
    public $withHistory = false;
    /**
     * @var bool Adjunta ultima ruta de la placa
     */
    public $withLastRoute = false;
    /**
     * @var bool Adjunta estado de cuarentena
     */
    public $withCuarentena = false;

    /**
     * @var bool Adjunta información de la máquina de inspección
     */
    public $withMachineInfo = false;

    public function barcode($barcode, $proceso = "")
    {
        $barcode = trim($barcode);
        $db = 'current';

        // El barcode es valido??
        if(is_numeric($barcode)) {
            // Buscar en BloqueHistory, retorna los resultados en orden descendiente
            // la primer inspeccion seria la ultima en el array de resultados
            $placas = BloqueHistoryController::buscar($barcode,$proceso);
            if(count($placas)>0)  {
                if(count($placas)==1)  {

                    $result = new \stdClass();


                    $result->first = $this->panelDataHandler($placas->last(),"last");
                    $result->last = $result->first;

                    if($this->withHistory ) {
                        $result->historial[] = $result->first;
                    }
                } else  {
                    $result = new \stdClass();


                    if($this->onlyLast) {
                        $result->first = null;
                    } else {

                        $result->first = $this->panelDataHandler($placas->last(),"last");
                    }

                    $result->last = $this->panelDataHandler($placas->first(),"first");

                    if($this->withHistory ) {
                        $result->historial = null;

                        foreach ($placas as $history) {
                            $result->historial[] = $this->panelDataHandler($history,"last");
                        }
                    }
                }
                return $result;

            } else
            {
                /*
                 * Sera una placa secundaria? en bloques las placas secundarias tienen el formato
                 * 0000123-XX y nosotros estamos buscando 0000123
                 * Hay que buscar en paneles el codigo sin el guion
                 */
                $panel = PanelHistoryController::buscarPanel($barcode,$proceso);
                if(count($panel) > 0) {

                    $result = new \stdClass();
                    if($this->onlyLast) {
                        $result->first = null;
                    } else {
                        $result->first = $this->panelDataHandler($panel->last(),"last");
                    }
                    $result->last = $this->panelDataHandler($panel->first(),"first");

                    if ($this->withHistory) {
                        $result->historial = null;
                        foreach ($panel as $history) {
                            $result->historial[] = $this->panelDataHandler($history,"last");
                        }
                    }
                    if($this->withMachineInfo)
                    {
                        $result->maquina = null;
                        $maquina = new Maquina();

                    }
                    return $result;
                } else
                {
                    $error = "No se localizo el barcode en AOI";
                    $output = compact('db','barcode', 'error');
                }
            }
        } else
        {
            $error = "El dato es invalido, solo se permite barcode numerico.";
            $output = compact('db','barcode', 'error');
        }
        return $output;
    }

    public function barcodeV1($barcode, $proceso = "")
    {
        $barcode = trim($barcode);
        $db = 'current';

        // El barcode es valido??
        if(is_numeric($barcode)) {
            // Buscar en BloqueHistoryController, retorna los resultados en orden descendiente
            // la primer inspeccion seria la ultima en el array de resultados
            $placas = BloqueHistoryController::buscar($barcode,$proceso);
            if(count($placas)>0)  {
                if(count($placas)==1)  {

                    $result = new \stdClass();


                    $result->first = $this->panelDataHandlerV1($placas->last(),"last");
                    $result->last = $result->first;

                    if($this->withHistory ) {
                        $result->historial[] = $result->first;
                    }
                } else  {
                    $result = new \stdClass();


                    if($this->onlyLast) {
                        $result->first = null;
                    } else {

                        $result->first = $this->panelDataHandlerV1($placas->last(),"last");
                    }

                    $result->last = $this->panelDataHandlerV1($placas->first(),"first");

                    if($this->withHistory ) {
                        $result->historial = null;

                        foreach ($placas as $history) {
                            $result->historial[] = $this->panelDataHandlerv1($history,"last");
                        }
                    }
                }
                return $result;

            } else
            {
                /*
                 * Sera una placa secundaria? en bloques las placas secundarias tienen el formato
                 * 0000123-XX y nosotros estamos buscando 0000123
                 * Hay que buscar en paneles el codigo sin el guion
                 */
                $panel = PanelHistory::buscarPanel($barcode,$proceso);
                if(count($panel) > 0) {

                    $result = new \stdClass();
                    if($this->onlyLast) {
                        $result->first = null;
                    } else {
                        $result->first = $this->panelDataHandlerV1($panel->last(),"last");
                    }
                    $result->last = $this->panelDataHandlerV1($panel->first(),"first");

                    if ($this->withHistory) {
                        $result->historial = null;
                        foreach ($panel as $history) {
                            $result->historial[] = $this->panelDataHandlerV1($history,"last");
                        }
                    }
                    if($this->withMachineInfo)
                    {
                        $result->maquina = null;
                        $maquina = new Maquina();

                    }
                    return $result;
                } else
                {
                    $error = "No se localizo el barcode en AOI";
                    $output = compact('db','barcode', 'error');
                }
            }
        } else
        {
            $error = "El dato es invalido, solo se permite barcode numerico.";
            $output = compact('db','barcode', 'error');
        }
        return $output;
    }

    public function barcodeNotHistory($barcode,$proceso)
    {
        $barcode = trim($barcode);
        $db = 'current';
        // El barcode es valido??
        if(is_numeric($barcode)) {
            // Buscar en Bloque, retorna los resultados en orden descendiente
            // la primer inspeccion seria la ultima en el array de resultados
            $placas = Bloque::buscar($barcode,$proceso);

            if(count($placas)>0)  {
                if(count($placas)==1)  {

                    $result = new \stdClass();


                    $result->first = $this->panelDataHandlerNotHistory($placas);
                    $result->last = $result->first;

                    if($this->withHistory ) {
                        $result->historial[] = $result->first;
                    }
                } else  {
                    $result = new \stdClass();


                    if($this->onlyLast) {
                        $result->first = null;
                    } else {

                        $result->first = $this->panelDataHandlerNotHistory($placas);
                    }

                    $result->last = $this->panelDataHandlerNotHistory($placas);

                    if($this->withHistory ) {
                        $result->historial = null;

                        foreach ($placas as $history) {
                            $result->historial[] = $this->panelDataHandlerNotHistory($history);
                        }
                    }
                }
                return $result;

            } else
            {
                /*
                 * Sera una placa secundaria? en bloques las placas secundarias tienen el formato
                 * 0000123-XX y nosotros estamos buscando 0000123
                 * Hay que buscar en paneles el codigo sin el guion
                 */
                $panel = Panel::buscarPanel($barcode,$proceso);
                if(count($panel) > 0) {

                    $result = new \stdClass();
                    if($this->onlyLast) {
                        $result->first = null;
                    } else {
                        $result->first = $this->panelDataHandlerNotHistory($panel);
                    }
                    $result->last = $this->panelDataHandlerNotHistory($panel);

                    if ($this->withHistory) {
                        $result->historial = null;
                        foreach ($panel as $history) {
                            $result->historial[] = $this->panelDataHandlerNotHistory($history);
                        }
                    }
                    if($this->withMachineInfo)
                    {
                        $result->maquina = null;
                        $maquina = new Maquina();

                    }
                    return $result;
                } else
                {
                    $error = "No se localizo el barcode en AOI";
                    $output = compact('db','barcode', 'error');
                }
            }
        } else
        {
            $error = "El dato es invalido, solo se permite barcode numerico.";
            $output = compact('db','barcode', 'error');
        }
        return $output;
    }

    private function panelDataHandler($placa,$mode)
    {
        $moreInfo = new \stdClass();

        $moreInfo->panelController = new PanelController();
        $moreInfo->panelHistoryController = new PanelHistoryController();

        if($placa instanceof PanelHistory)
        {
            $moreInfo->panel = $placa;
            $moreInfo->bloque = null;
        }

        
        
        
        if($placa instanceof BloqueHistory)
        {
            $moreInfo->panel = $placa->panel;
            $moreInfo->bloque = $placa;
        }
        $bloques = BloqueHistory::where('id_panel_history', $moreInfo->panel->id_panel_history)->get();
        
        
        
        $moreInfo->analisis = $this->analisisDespacho($bloques,$moreInfo->panel);
        
        
        if($this->withSmt) {
            $moreInfo->smt = $moreInfo->panelHistoryController->smt($moreInfo->panel);
        }
        
        
        
        if($this->withCogiscan)
        {
            $moreInfo->cogiscan = $moreInfo->panelHistoryController->cogiscan();
        }
        
        
        
        if($this->withWip)
        {
            $verify = new VerificarDeclaracion();
            // $verifyResult = $verify->panelEnTransaccionesWipOrCheckInterfazWip($placa->barcode);
            $verifyResult = $verify->bloqueEnTransaccionWip($placa->barcode);
            $moreInfo->wip = $verifyResult;
        }


        
        if($this->withCuarentena)
        {
            $cuarentena = new CuarentenaController();
            $moreInfo->cuarentena = $cuarentena->getDetail($placa->barcode);
        }
        
        
        return $moreInfo;
    }

    private function panelDataHandlerV1($placa,$mode)
    {
        $moreInfo = new \stdClass();

        if($placa instanceof PanelHistory)
        {
            $moreInfo->panel = $placa;
            $moreInfo->bloque = null;
        }

        if($placa instanceof BloqueHistory)
        {
            $moreInfo->panel = $placa->panel;
            $moreInfo->bloque = $placa;
        }
        
        // $bloques = BloqueHistory::where('id_panel_history', $moreInfo->panel->id_panel_history)->get();

        // $moreInfo->analisis = $this->analisisDespacho($bloques,$moreInfo->panel);


        if($this->withSmt) {
            $moreInfo->smt = $moreInfo->panel->smt();
        }

        // if($this->withCogiscan)
        // {
        //     $moreInfo->cogiscan = $moreInfo->panel->cogiscan();
        // }

        // if($this->withWip)
        // {
        //     $verify = new VerificarDeclaracion();
        //     $verifyResult = $verify->bloqueEnTransaccionWip($placa->barcode);
        //     $moreInfo->wip = $verifyResult;
        // }

        // if($this->withCuarentena)
        // {
        //     $cuarentena = new CuarentenaController();
        //     $moreInfo->cuarentena = $cuarentena->getDetail($placa->barcode);
        // }


        return $moreInfo;
    }


    private function panelDataHandlerNotHistory($placa)
    {
        $moreInfo = new \stdClass();

        $placa = head(head($placa));
        if($placa instanceof Panel)
        {
            $moreInfo->panel = $placa;
            $moreInfo->bloque = null;
        }



        if($placa instanceof Bloque)
        {
            $moreInfo->panel = $placa->panel;
            $moreInfo->bloque = $placa;
        }

        $bloques = Bloque::where('id_panel', $moreInfo->panel->id)->get();



        $moreInfo->analisis = $this->analisisDespacho($bloques,$moreInfo->panel);


        if($this->withSmt) {
            $moreInfo->smt = $moreInfo->panel->smt();
        }



        if($this->withCogiscan)
        {
            $moreInfo->cogiscan = $moreInfo->panel->cogiscan();
        }



        if($this->withWip)
        {
            $verify = new VerificarDeclaracion();
//            $verifyResult = $verify->panelEnTransaccionesWipOrCheckInterfazWip($placa->barcode);
            $verifyResult = $verify->bloqueEnTransaccionWip($placa->barcode);
            $moreInfo->wip = $verifyResult;
        }



        if($this->withCuarentena)
        {
            $cuarentena = new CuarentenaController();
            $moreInfo->cuarentena = $cuarentena->getDetail($placa->barcode);
        }


        return $moreInfo;
    }
/*
 * BACKUP DE FUNCION
    public function barcode($barcode)
    {
        $db = 'current';

        // Si el barcode es valido, se realiza la busqueda en PanelHistory
        if(is_numeric($barcode)) {
            $panel = PanelHistory::buscar($barcode);

            // Si encontro resultados...
            if($panel!=null)
            {
                $result = new \stdClass();
                $result->last = $this->panelDataHandler($barcode,collect($panel)->first());

                if(count($panel)>1 && !$this->onlyLast )
                {
                    $result->historial = null;

                    foreach($panel as $historyPanel)
                    {
                        $result->historial[] = $this->panelDataHandler($barcode,$historyPanel);
                    }
                }

                return $result;
            } else
            {
                $error = "No se localizo el barcode en AOI";
                $output = compact('db','barcode', 'error');
            }

        } else
        {
            $error = "El dato es invalido, solo se permite barcode numerico.";
            $output = compact('db','barcode', 'error');
        }

        return $output;
    }*/

/*
    private function panelDataHandler($barcode,  $panel,$debug=false)
    {
        $moreInfo = new \stdClass();
        $moreInfo->panel = $panel;
        $moreInfo->bloque = null;
        $moreInfo->detalle = null;
        $moreInfo->production = null;
        $moreInfo->smt = null;
        $moreInfo->analisis = null;
        $moreInfo->wip = null;

        if (isset($panel->panel_barcode))
        {
            $bloques = BloqueHistory::where('id_panel_history', $panel->id_panel_history)->get();

            $bloque = $bloques->where('barcode',$barcode)->first();

            $moreInfo->analisis = $this->analisisDespacho($bloques,$panel);
            if($moreInfo->analisis->mode == 'E')
            {
                $moreInfo->bloque = $bloque;
            }

            if ($this->withDetail) {
                if($bloque!=null)
                {
                    $moreInfo->detalle = DetalleHistory::fullDetail($bloque->id_bloque_history)->get();
                }
            }

            if ($this->withProductioninfo) {
                $moreInfo->production = Produccion::maquina($panel->id_maquina);
            }

            if($this->withSmt) {
                $moreInfo->smt = $panel->smt();
            }
            if($this->withCogiscan)
            {
                $moreInfo->cogiscan = $panel->cogiscan();
            }

            if($this->withWip)
            {
                $verify = new VerificarDeclaracion();
                $verifyResult = $verify->bloqueEnTransaccionWip($bloque->barcode);
                $moreInfo->wip = $verifyResult;
            }
            return $moreInfo;

        } else {
            $error = "No se localizo el barcode en AOI";
            return compact('error');
        }
    }
*/
    private function analisisDespacho($bloqueHistory, $panelHistory)
    {
        $info = new \stdClass();
        $info->despachar = false;
        $info->mode = 'U';

        $info->etiqueta_fisica = count(Arr::where($bloqueHistory->toArray(), function ($key, $value) {
            if($value["etiqueta"] == 'E'){
                return $value;
            }
        }));
        
        $info->etiqueta_virtual = count(Arr::where($bloqueHistory->toArray(), function ($key, $value) {
            if($value["etiqueta"] == 'V'){
                return $value;
            }
        }));
        
        if($info->etiqueta_fisica == $panelHistory->bloques) {
            $info->despachar = true;
            $info->mode = 'E';
        }
        
        if($info->etiqueta_virtual == $panelHistory->bloques) {
            $info->despachar = true;
            $info->mode = 'V';
        }
        
        if($panelHistory->revision_ins == 'OK' && $info->mode != 'U')
        {
            $info->despachar = true;
        }
        
        return $info;
    }

    public function findByReference($barcode="",$reference="")
    {
        $returnView=true;
        if($barcode=="" && $reference=="")
        {
            $input = Input::all();
            $barcode = $input['barcode'];
            $reference = $input['reference'];
        }
        else
        {
            $returnView = false;
        }
        $data = new \stdClass();
        $query = DB::connection('aoidata')->table('history_inspeccion_bloque as ib')
            ->selectRaw("
            ib.barcode,
            id.referencia,
            id.estado
            ")
            ->leftJoin('aoidata.history_inspeccion_detalle as id','ib.id_bloque_history','=','id.id_bloque_history')
            ->leftJoin('aoidata.history_inspeccion_panel as ip','ib.id_panel_history','=','ip.id_panel_history')
            ->where('ib.barcode',$barcode)
            ->where('id.referencia',$reference)
            ->orderBy('ip.fecha','asc')
            ->orderBy('ip.hora','asc')
            ->take(1)->get();

        $panelBarcode = self::formatPanelBarcode($barcode);
        $panel = $this->findPanelDetail($panelBarcode);


        $data->barcode = $barcode;
        $data->referencia = $reference;
        if(count($query) > 0)
        {
            $data->estado = $query[0]->estado;
        }
        else
        {
            $data->estado = "NO ENCONTRADO";
        }
        //si hay datos de panel
        if(count($panel) > 0)
        {
            $data->linea = "SMD-".$panel->linea;
            $data->modelo = $panel->modelo;
            $data->panel = $panel->panel;
            $data->programa = $panel->programa;
            $data->fecha = $panel->fecha;
            $data->hora = $panel->hora;
            $data->turno = $panel->turno;
            $data->inspected_op = $panel->inspected_op;
            $data->semielaborado = $panel->semielaborado;
        }
        else
        {
            $data->linea = "NO ENCONTRADO";
            $data->modelo = "NO ENCONTRADO";
            $data->panel = "NO ENCONTRADO";
            $data->programa = "NO ENCONTRADO";
            $data->fecha = "NO ENCONTRADO";
            $data->hora = "NO ENCONTRADO";
            $data->turno = "NO ENCONTRADO";
            $data->inspected_op = "NO ENCONTRADO";
            $data->semielaborado = "NO ENCONTRADO";
        }
        if($returnView)
        {
            return view('aoicollector.inspection.search_by_references',["data" => $data,"result"=>"simple"]);
        }
        else
        {
            return $data;
        }
    }

    /**
     * Busca el detalle de un Panel
     * @param $barcode
     * @return mixed
     */
    public function findPanelDetail($barcode)
    {

        $query = DB::connection('aoidata')->table('history_inspeccion_bloque as hib')
            ->selectRaw("
            hip.id_panel_history,
            m.linea,
            hip.programa,
            hip.fecha,
            hip.hora,
            hip.turno,
            hip.inspected_op,
            ot.modelo,
            ot.panel,
            ot.lote,
            ot.semielaborado
            ")
            ->leftJoin('aoidata.history_inspeccion_panel as hip','hip.id_panel_history','=','hib.id_panel_history')
            ->leftJoin('aoidata.maquina as m','hip.id_maquina','=','m.id')
            ->leftJoin('smtdatabase.orden_trabajo as ot','hip.inspected_op','=','ot.op')
            ->where('hib.barcode',$barcode)
            ->orderBy('hip.hora','asc')
            ->first();

        return $query;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findByReferenceMultiple(Request $request)
    {
        $data = $request->data;
        $renglones = preg_split('/\r\n|\r|\n/',$data);

        $arr = [];
        foreach($renglones as $renglon)
        {
            $renglon = preg_split('/\t/',$renglon);

            if(count($renglon) > 1)
            {
                $datos = new \stdClass();
                $datos->barcode = $renglon[0];
                $datos->referencia = $renglon[1];
                $result = self::findByReference($datos->barcode,$datos->referencia);
                if (count($result) > 0)
                {
                    $datos->estado = $result->estado;
                    $datos->linea = $result->linea;
                    $datos->modelo = $result->modelo;
                    $datos->panel = $result->panel;
                    $datos->inspected_op = $result->inspected_op;
                    $datos->fecha = $result->fecha;
                    $datos->hora = $result->hora;
                    $datos->turno = $result->turno;
                    $datos->semielaborado = $result->semielaborado;
                }
                else
                {
                    $datos->estado = "NO ENCONTRADO";
                }
                array_push($arr,$datos);
            }
        }


        return view('aoicollector.inspection.search_by_references',["data" => $arr,"result"=>"multiple"]);
    }

    /**
     * Formatea un barcode para convertirlo en panel
     * @param $barcode
     * @return mixed
     */
    public static function formatPanelBarcode($barcode)
    {
        // Si el barcode contiene un '-' quiere decir que es un bloque y no un panel
        if(strpos($barcode,'-') == true)
        {
            $tempBarcode = [];
            $tempBarcode = explode('-',$barcode);
            $barcode = $tempBarcode[0];
        }
        return $barcode;
    }
}