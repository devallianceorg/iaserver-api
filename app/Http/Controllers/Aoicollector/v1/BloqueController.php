<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Controller;

class BloqueController extends Controller
{
  public static function buscar($barcode,$proceso="")
  {
    $q = Bloque::where('ib.barcode', $barcode)
        ->from('aoidata.inspeccion_bloque as ib')
        ->leftjoin('aoidata.inspeccion_panel as ip','ib.id_panel','=','ip.id')
        ->leftjoin('aoidata.maquina as m','ip.id_maquina','=','m.id')
        ->where('ib.etiqueta','E');

    if($proceso == "B")
    {$q = $q->where('m.proceso','B');}

    $q = $q->orderBy('ib.id_panel', 'desc')
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
}