<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Aoicollector\Model\BloqueHistory;
use App\Http\Controllers\Aoicollector\v1\Inspection\VerificarDeclaracion;
use App\Http\Controllers\Controller;

class BloqueHistoryController extends Controller
{
  public static function buscar($barcode,$proceso="")
    {
        $q = BloqueHistory::where('hib.barcode', $barcode)
            ->from('history_inspeccion_bloque as hib')
            ->leftjoin('history_inspeccion_panel as hip','hib.id_panel_history','=','hip.id_panel_history')
            ->leftjoin('maquina as m','hip.id_maquina','=','m.id')
            ->where('hib.etiqueta','E');

            if($proceso == "B")
            {$q = $q->where('m.proceso','B');}

            $q = $q->orderBy('hib.id_panel_history', 'desc')
                    ->get();

//        $q->orderBy('hib.id_panel_history', 'desc')
//            ->get();

//        if(count($q)== 0)
//        {
//            $q = PanelHistory::select('panel_barcode as barcode','etiqueta','revision_aoi','revision_ins')
//                ->where('panel_barcode',$barcode)
//                ->orderBy('id_panel_history','desc')
//                ->get();
//        }
        return $q;
    }

    public function wip($op)
    {
        $verify = new VerificarDeclaracion();
        return $verify->wip($this->barcode,$op);
    }

    public function twip()
    {
        $verify = new VerificarDeclaracion();
        return $verify->twip($this->barcode);
    }
}