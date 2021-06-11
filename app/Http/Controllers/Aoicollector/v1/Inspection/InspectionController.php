<?php

namespace App\Http\Controllers\Aoicollector\v1\Inspection;

use Carbon\Carbon;
use App\Http\Controllers\Aoicollector\Model\PanelHistory;
use App\Http\Controllers\Aoicollector\Model\BloqueHistory;
use App\Http\Controllers\Aoicollector\Model\DetalleHistory;
use App\Http\Controllers\Aoicollector\Model\Maquina;
use App\Http\Controllers\Aoicollector\Model\Panel;

use App\Http\Controllers\Aoicollector\Stocker\PanelStockerController;
use App\Http\Controllers\IAServer\Util;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class InspectionController extends Controller
{
    /**
     * Muestra las inspecciones, por defecto muestra se muestra la primer maquina de la lista
     *
     * @return \Illuminate\View\View
     */
    public function listDefault()
    {
        $pagina = 1;
        $maquina = Maquina::orderBy('linea')->take(1)->first();
        return $this->listWithFilter($maquina->id,$pagina);
    }

    public function listWithOpFilter($op, $pagina=null)
    {
        $maquina = Maquina::orderBy('linea')->take(1)->first();
        return $this->listWithFilter($maquina->id,$pagina,$op);
    }

    public function defectosPeriodo()
    {
        $carbonDate = Util::dateRangeFilterEs('defectos_date_session');

        $maquinas = Maquina::select('maquina.*','produccion.inf','produccion.cogiscan')
            ->orderBy('maquina.linea')
            ->leftJoin('aoidata.produccion','produccion.id_maquina','=','maquina.id')
            ->get();

        $inspectionList = new InspectionList();
        $inspectionList->setDate($carbonDate->desde,$carbonDate->hasta);
        $inspectionList->setIdMaquina($maquinas->first()->id);
        $defectChart = $inspectionList->queryDefectInspectionRange()->get();

        $maquina = $maquinas->first();

        $output = compact('defectChart','maquinas','maquina');

        return Response::multiple($output,'aoicollector.inspection.periodo_defectos');
    }

    public function listWithFilter($id_maquina,$pagina=null,$op='')
    {
        $id_maquina = (int) $id_maquina;
        

        $carbonDate = Util::dateRangeFilterEs('inspection_date_session');

        $inspectionList = new InspectionList();
        $inspectionList->setDate($carbonDate->desde,$carbonDate->hasta);


        $inspectionList->setIdMaquina($id_maquina);
        $inspectionList->setPagina($pagina);
        $inspectionList->setMode(Request::get('listMode'));
        $inspectionList->setPeriod(Request::get('filterPeriod'));
        $inspectionList->programsUsedByIdMaquina();
        
        if(!empty($op))
        {
            $inspectionList->setOp($op);
        }
        
        $inspectionList->find();
        
        // Sidebar
        $maquinas = Maquina::select('maquina.*','produccion.inf','produccion.cogiscan')
        ->orderBy('maquina.linea')
        ->leftJoin('aoidata.dbo.produccion','produccion.id_maquina','=','maquina.id')
        ->get();
        
        $maquina = $maquinas->where('id',$id_maquina)->first();

        $output = compact('inspectionList','maquinas','maquina');
       
        return $output;
    }

    /**
     * Muestra las inspecciones, filtradas por maquina
     *
     * @param $id_maquina
     * @param null $pagina
     * @return \Illuminate\View\View

    public function listWithFilterORIGINAL($id_maquina,$pagina=null,$op='')
    {
        $insp = array();
        $por_pagina = 50;

        $maquina = Maquina::select('maquina.*','produccion.cogiscan')
        ->orderBy('maquina.linea')
        ->leftJoin('aoidata.produccion','produccion.id_maquina','=','maquina.id')
        ->where('maquina.id',$id_maquina)
        ->first();


        // Crea una session para filtro de fecha
        Filter::dateSession();

        // Por defecto la pagina a mostrar es la 1
        if(is_null($pagina)) { $pagina = 1; }

        // Obtengo la fecha, y cambio el formato 16-09-2015 -> 2015-09-16
        $fecha = Util::dateToEn(Session::get('inspection_date_session'));

        $total = PanelHistory::listar($id_maquina, $fecha, $op)->count();

        $programas = array();
        if(empty($op))
        {
            $programas = PanelHistory::programUsed($id_maquina, $fecha);
        }

        if(is_numeric($total)>0 )
        {
            $skip = ($pagina-1) * $por_pagina;
            $insp = PanelHistory::listar($id_maquina, $fecha, $op)->take($por_pagina)->skip($skip)->get();

            // Calcula paginas segun total y resultados a mostrar por pagina
            $paginas = ceil($total / $por_pagina);
        } else {
            $total = 0;
        }

        $maquinas = Maquina::select('maquina.*','produccion.cogiscan')
            ->orderBy('maquina.linea')
            ->leftJoin('aoidata.produccion','produccion.id_maquina','=','maquina.id')
            ->get();

        $output = compact('insp','maquinas','maquina','total','pagina','por_pagina','paginas','programas');

        return Response::multiple($output,'aoicollector.inspection.index');
    }
    */

    /**
     * Muestra los bloques pertenecientes a un panel
     *
     * @param int $id_panel
     * @return Response Response::multiple($output,'aoicollector.inspection.partial.blocks');
     */
    public function listBlocks($id_panel)
    {
        //$bloques = BloqueController::listar($id_panel);
        $bloques = BloqueHistory::where('id_panel_history',$id_panel)->get();
        $output = compact('bloques');

        return Response::multiple($output,'aoicollector.inspection.partial.blocks');
    }

    /**
     * Muestra los detalles de inspeccion de un bloque
     *
     * @param int $id_bloque
     * @return Response Response::multiple($output,'aoicollector.inspection.partial.detail');
     */
    public function listDetail($id_bloque,$id_panel=null)
    {
        
        if(isset($id_panel)){
            $panel = PanelHistory::where('id_panel_history',$id_panel)->first();
            if(isset($panel))
            {        
                $tipo_maquina = Maquina::select('tipo')->where('id',$panel->id_maquina)->first();
                if(isset($tipo_maquina->tipo)){
                    $tipo_maquina = $tipo_maquina->tipo;
                }
            }
        }
        else{
            $tipo_maquina = 'R';
        }
//        $detalle = DetalleController::listar($id_bloque);
        $detalle = DetalleHistory::fullDetail($id_bloque,$tipo_maquina)->get();
        $output = compact('detalle');

        return Response::multiple($output,'aoicollector.inspection.partial.detail');
    }

    /**
     * Muestra los resultados de busqueda de un barcode
     *
     * @return Response Response::multiple($output,'aoicollector.inspection.search_barcode');
     * Tambien puede devolver solo los datos de la inspección enviando la variable $return_view = false
     */
    public function searchBarcode($search_barcode = "",$return_view = "true")
    {

        $timeline = true;
        $barcode = Input::get('barcode');
        $maquina = null;
        $insp_by_date = array();
        $maquinas = Maquina::orderBy('linea')->get();

        if(!empty($search_barcode)) {
            $barcode = $search_barcode;
        }

        $findService = new FindInspection();
        $findService->withCogiscan = true;
        $findService->withSmt = true;
        $findService->withHistory = true;
        $findService->withWip = true;

        $insp = (object) $findService->barcode($barcode,"");
        if(isset($insp->last))
        {
            if(isset($insp->last->panel->id_maquina)) {
                $maquina = Maquina::find($insp->last->panel->id_maquina);
            }

            if(isset($insp->historial))
            {
                $insp_by_date = collect($insp->historial)->groupBy('panel.created_date');
            } else
            {
                $insp_by_date[$insp->last->panel->created_date] = $insp;
            }
        }

        if(!$maquina)
        {
            $maquina = Maquina::orderBy('linea')->take(1)->first();
        }



        if($return_view == "true")
        {
            $output = compact('insp','insp_by_date','maquinas','maquina','timeline','barcode');
            return Response::multiple($output,'aoicollector.inspection.search_barcode'); }
        else
        {
            $output = compact('insp','maquina','barcode');
            return $output; }

    }

    /**
     * Muestra los resultados de busqueda de multiples Barcodes
     * @return mixed
     */
    public function multipleSearchBarcode()
    {

        $regex = '/([0-9]+)/';

        $firstOrLast = Input::get('mode');
        if(!isset($firstOrLast))
        {
            $firstOrLast = 'first';
        }

        $input = Input::get('barcodes');
        preg_match_all($regex, $input, $matches);

        $barcodes = [];
        foreach ($matches[0] as $barcode) {

            $find = new FindInspection();
            $find->withSmt = true;
            $find->withWip = true;
            $inspeccion = (object) $find->barcode($barcode,"");

            if(isset($inspeccion->error))
            {
                $barcodes[] = $inspeccion;
            } else
            {
                if($firstOrLast=='first')
                {
                    $barcodes[] = $inspeccion->first;
                } else
                {
                    $barcodes[] = $inspeccion->last;
                }
            }
        }
        $maquinas = Maquina::orderBy('linea')->get();
        $maquina = $maquinas->first();
        $output = compact('maquinas','maquina','barcodes');

        return Response::multiple($output,'aoicollector.inspection.multiplesearch');
    }

    public function searchReference($reference, $id_maquina, $turno, $fecha_eng, $progama,$realOFalso = 'real',$type)
    {

        $search_reference = $reference;

      //  dd($realOFalso);

        $panel_barcodes = $this->findPanelWithReference($id_maquina, $turno, $fecha_eng, $progama, $reference, $realOFalso,$type);
      //  dd($panel_barcodes);
        $maquina = Maquina::find($id_maquina);
        foreach($panel_barcodes as $p)
        {
            $insp[$p->panel_barcode] = PanelHistory::buscar($p->panel_barcode);
        }

        $maquinas = Maquina::orderBy('linea')->get();

       

        $output = compact('insp','maquinas','maquina','search_reference');

        return Response::multiple($output,'aoicollector.inspection.search_reference');
    }

    public function findPanelWithReference($id_maquina, $turno, $fecha, $programa, $reference, $estado, $resume_type)
    {
        
        if($resume_type == 'first'){

            $resume_type = 'last';

        }else{
            
            $resume_type = 'first';
        }

        $query = "CALL aoidata.sp_getFindPanelWithReferenceFromHistory('".$id_maquina."','".$programa."','".$turno."','".$fecha."','".$reference."','".$estado."','".$resume_type."');";

        $sql = DB::connection('aoidata')->select($query);

        //dd($sql);

        return $sql;
    }

    public function forceOK($barcode,$forceMultiple=false)
    {
        $findService = new FindInspection();
        $findService->onlyLast = true;
        $insp = (object) $findService->barcode($barcode,"");
        $insp->last->panel->revision_ins = 'OK';

        $insp->last->panel->save();

        $bloquesHistory = BloqueHistory::where('id_panel_history',$insp->last->panel->id_panel_history)->get();

        foreach($bloquesHistory as $bloque)
        {
            $bloque->revision_ins = 'OK';
            $bloque->save();
        }

        if(!$forceMultiple)
        {
            dd('done',$insp->last);
        }
        else
        {
            return $insp->last;
        }

    }

    public function forceOKMultiple()
    {
        $regex = '/([0-9\-]+)/';

        $input = Input::get('barcodes');
        preg_match_all($regex, $input, $matches);
        $barcodes = [];
        $res = [];
        $count = 0;
        $panel = new PanelStockerController();
        foreach($matches[0] as $barcode)
        {
            $forced = $panel->forceTransaccionWip($barcode);
            $res = [$barcode,$forced];
            array_push($barcodes,$res);
            $count++;
        }
        dd($barcodes,'Forzados -> '.$count);
    }

    public function createInspection(Request $req)
    {
        $regex = '/([0-9]+)/';

        
        $input = $req->get('barcodes');
        $op = $req->get('op');
        $chkBox = $req->get('chkBox');
        $ng = $req->get('ng');
        
        preg_match_all($regex, $input, $matches);

        $panel = null;
        $bloques = null;
        $barcodes = $matches[0];

        
        foreach ($barcodes as $index => $barcode) {
            $index++;
            if($panel==null)  {
                $create = new CreateInspection();
                if($chkBox == null)
                {
                    $qtyBloques = count($barcodes);
                }
                else
                {
                    $qtyBloques  = 1;
                }
                $panel = $create->createPanel($barcode,$qtyBloques,$op,$ng);

                return $panel;
                $bloques[] = $create->createBlock($panel,$barcode,$index);
                if(isset($chkBox))
                {
                    $panel = null;
                    $index--;
                }
            } else
            {
                $create = new CreateInspection();
                $bloques[] = $create->createBlock($panel,$barcode,$index);
            }
        }

        dd($panel,$bloques,'done');
    }



    public function searchByReferences()
    {
        return view('aoicollector.inspection.search_by_references');
    }
}