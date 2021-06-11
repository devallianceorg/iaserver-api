<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Aoicollector\Model\Panel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
  public static function sinDeclarar($op) {
    $query = "
    select
    stk.barcode as stocker_barcode,
          tw.trans_ok,
          tw.trans_det,
          stkroute.name as stocker_route,
          proute.name as panel_route,
          hp.*
      from history_inspeccion_panel as hp
      inner join inspeccion_panel as p on hp.id_panel_history = p.last_history_inspeccion_panel
    left join transaccion_wip as tw on tw.barcode = hp.panel_barcode
      left join stocker_detalle as stkd on stkd.id_panel = p.id
      left join stocker as stk on stk.id = stkd.id_stocker
      left join stocker_traza as stkt on stkt.id_stocker = stk.id and stkt.id = (SELECT MAX(substkt.id) FROM stocker_traza substkt where substkt.id_stocker =  stkd.id_stocker)
      left join stocker_route as stkroute on stkroute.id = stkt.id_stocker_route
      left join stocker_route as proute on proute.id = tw.id_last_route

  where

      hp.inspected_op = '$op'

      and not exists (
              select stw.trans_ok from transaccion_wip as stw where
              stw.barcode = hp.panel_barcode and
              stw.trans_ok = 1
          )

      order by hp.created_date asc, hp.created_time asc";


    //   DEPRECAR
      return DB::connection('aoidata')->select(DB::raw($query));
  }

  public static function buscar($barcode)
  {
      // Primero busca en PanelHistory
      $panel = self::buscarPanel($barcode);
      if(count($panel)>0)
      {
          return $panel;
      } else
      {
          // Luego busca en BloqueHistory
  //            $bloque = BloqueHistory::buscar($barcode);

          $bloque = Bloque::buscar($barcode);

          if (count($bloque) > 0)
          {
              $panel_barcode = $bloque->first()->panel->panel_barcode;
              return self::buscarPanel($panel_barcode);
          } else {

              // Si no encontro nada, busca en Panel, donde seguramente se encuentre en estado PENDIENTE
              $panel = Panel::buscarPanel($barcode);
              if(count($panel)>0)
              {
                  return $panel;
              }
          }
      }
  }

  /**
   * Busca el barcode en Panel
   *
   * @param string $barcode
   * @return mixed
   */
  public static function buscarPanel($barcode,$proceso="")
  {
      $query = Panel::where('ip.panel_barcode',$barcode)
          ->from('aoidata.inspeccion_panel as ip')
          ->leftJoin('aoidata.maquina as m', 'm.id','=','ip.id_maquina');
      if($proceso =="B")
      {$query = $query->where('m.proceso','B');}

      $query = $query->orderBy('ip.created_date','desc')
          ->orderBy('ip.created_time','desc')
          ->select(['ip.*','m.linea'])
          ->get();

      return $query;
  }

  function isSecundario($panel)
  {
      $etiquetasVirtuales = Panel::where("panel_barcode",$panel->panel_barcode)->first()->joinBloques()->where('etiqueta','V')->count();
      if($panel->bloques == $etiquetasVirtuales) {
          return true;
      } else
      {
          return false;
      }
  }
}