<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Smtdatabase;
use App\Http\Controllers\Trazabilidad\v1\Wip\Wip;

class AoicollectorController extends Controller
{
  function __construct()
  {
    
  }

  public function cogiscan()
  {
      $cogiscanService= new Cogiscan();
      return $cogiscanService->queryItem($this->panel_barcode);
  }

  public function smt()
  {
      $w = new Wip();
      $smt = Smtdatabase::findOp($this->inspected_op);

      // Obtengo semielaborado desde interfaz
      $wipResult = $w->findOp($this->inspected_op,false,false);
      $semielaborado =null;
      if(isset($wipResult->wip_ot->codigo_producto))
      {
          $semielaborado = $wipResult->wip_ot->codigo_producto;
      }
      $smt->semielaborado = $semielaborado;

      unset($smt->op);
      unset($smt->id);
      unset($smt->prod_aoi);
      unset($smt->prod_man);
      unset($smt->qty);

      return $smt;
  }

    
}