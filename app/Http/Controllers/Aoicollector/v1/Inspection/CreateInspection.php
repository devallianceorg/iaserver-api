<?php

namespace App\Http\Controllers\Aoicollector\v1\Inspection;

use Carbon\Carbon;
use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Aoicollector\Model\Panel;

use App\Http\Controllers\SMTDatabase\Model\OrdenTrabajo;
use App\Http\Controllers\SMTDatabase\v1\SMTDatabase;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CreateInspection extends Controller
{
   public function createPanel($barcode,$bloques,$op,$ng)
   {
       $insp= new Panel();

       $insp->id_maquina = 7; // Ex linea 15
       $insp->panel_barcode = $barcode;
       $insp->programa = 'AUTOMATIC';
       $insp->fecha = Carbon::now()->toDateString();
       $insp->hora = Carbon::now()->toTimeString();
       $insp->turno = 'M';
       $insp->revision_aoi = !isset($ng) ? 'OK' : 'NG';
       $insp->revision_ins = !isset($ng) ? 'OK' : 'NG';
       $insp->errores = 0;
       $insp->falsos = 0;
       $insp->reales = 0;
       $insp->bloques = $bloques;
       $insp->etiqueta = 'E';
       $insp->inspected_op = $op;
       $insp->semielaborado = '';
       $insp->insp_type = 'inspector';
       $insp->pendiente_inspeccion = 0;
       $insp->test_machine_id = 0;
       $insp->program_name_id = 0;
       $insp->id_user = 0;
       $insp->first_history_inspeccion_panel = 0;
       $insp->last_history_inspeccion_panel = 0;
       $insp->created_at = Carbon::now();
       $insp->created_date = Carbon::now()->toDateString();
       $insp->created_time = Carbon::now()->toTimeString();
       $insp->save();

       $hpanel = $this->sp_insertHistoryPanel($insp->id);

       $hpanel = collect($hpanel)->first();

       return compact('insp','hpanel');
    }

    public function createBlock($insp,$barcode,$numBloque)
    {

        $insp = (object) $insp;
        $panel = $insp->insp;
        $panelHistoryId = $insp->hpanel->id;
//        dd($panel->inspected_op);

        $bloque = new Bloque();
        $bloque->id_panel = $panel->id;
        $bloque->barcode = $barcode;
        $bloque->etiqueta = $panel->etiqueta;
        $bloque->revision_aoi = $panel->revision_aoi;
        $bloque->revision_ins = $panel->revision_ins;
        $bloque->errores = $panel->errores;
        $bloque->falsos = $panel->falsos;
        $bloque->reales = $panel->reales;
        $bloque->bloque = $numBloque;
        $bloque->save();

        $hbloque = $this->sp_insertHistoryBlock($panelHistoryId,$bloque->id);

        // Para actualizar la cantidad de placas producidas por AOI

        $updPoQty = OrdenTrabajo::where('op',$panel->inspected_op)->first();
        $updPoQty->prod_aoi = $updPoQty->prod_aoi + 1;
        $updPoQty->save();


        return $hbloque;
    }

    public function sp_insertHistoryPanel($idPanel) {
        $sql = DB::connection('aoidata')->select("EXEC sp_insertHistoryPanel @idPanel=".$idPanel.", @modo='insert'");

        return $sql;
    }

    public function sp_insertHistoryBlock($idPanelHistory,$idBloque) {
        //dump($query);
        $sql = DB::connection('aoidata')->select("EXEC sp_insertHistoryBlock @idPanelHistory=".$idPanelHistory.", @idBloque=".$idBloque);

        return $sql;
    }
}