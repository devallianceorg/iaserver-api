<?php

namespace App\Http\Controllers\Aoicollector\v1\Inspection;

use App\Http\Controllers\Aoicollector\Model\Stocker;
use App\Http\Controllers\Aoicollector\Model\TransaccionWip;
// use App\Http\Controllers\Aoicollector\Model\TransaccionWip;
use App\Http\Controllers\Aoicollector\v1\Stocker\Src\StockerContentDeclaracion;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trazabilidad\v1\Wip\Wip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerificarDeclaracion extends Controller
{
    public $declaracion = null;
    public $bloques = [];

    public function __construct()
    {
        $this->declaracion = new StockerContentDeclaracion();
    }

    public function panelSecundarioEnInterfazWip($panel)
    {
        $w = new Wip();
        if(Str::endsWith($panel->inspected_op,"-B"))
        {
            $panel->inspected_op = Str::replaceFirst("-B","",$panel->inspected_op);
        }
        $wip = $w->findBarcodeSecundario($panel->panel_barcode, $panel->inspected_op);
        
        if(count($wip)>0)
        {
            // A veces al re intentar declarar en la interfaz existen muchos intentos de declaraciones.
            // Solo vamos a tomar el ultimo intento de cada placa
            $placas = [];

            foreach($wip->groupBy('referencia_1') as $placaBarcode => $interfaz) {
                $placa = $interfaz->last();
                $placas[] = $placa;

                $addBloque = new \stdClass();
                $addBloque->bloque = $placa;
                $addBloque->declaracion = new StockerContentDeclaracion();

                $trans_ok = (int) $placa->trans_ok;

                $addBloque->declaracion->declarado_total = ($trans_ok == 1 ? 1 : 0 );
                $addBloque->declaracion->pendiente_total = ($trans_ok == 0 ? 1 : 0 );
                $addBloque->declaracion->error_total = ($trans_ok > 1 ? 1 : 0 );
                $addBloque->declaracion->process(1);

                $addBloque->wip = $placa;

                $this->bloques[] = $addBloque;
            }

            $placas = collect($placas);

            

            $this->declaracion->declarado_total = $placas->where('trans_ok','1')->count();
            $this->declaracion->pendiente_total = $placas->where('trans_ok','0')->count();
            $this->declaracion->error_total = $placas->where('trans_ok','<>','0')->count() + $placas->where('trans_ok','<>','1')->count();

            $this->declaracion->process($panel->bloques);
        }

        return $this;
    }

    public function listaPanelesEnInterfazWip($op)
    {

//        $w = new Wip();
//
//        return
    }

    public function panelEnInterfazWip($panel)
    {
        $jbloques = clone $panel;
        foreach($jbloques->joinBloques as $bloque)
        {
            if(Str::endsWith($panel->inspected_op,"-B"))
            {
                $panel->inspected_op = Str::replaceFirst("-B","",$panel->inspected_op);
            }
            $interfaz = self::bloqueEnInterfazWip($bloque->barcode,$panel->inspected_op);

            $addBloque = new \stdClass();
            $addBloque->bloque = $bloque;
            $addBloque->declaracion = $interfaz->declaracion;
            $addBloque->wip = $interfaz->wip;

            $this->bloques[] = $addBloque;
        }

        $this->declaracion->declarado_total = collect($this->bloques)->sum('declaracion.declarado_total');
        $this->declaracion->pendiente_total = collect($this->bloques)->sum('declaracion.pendiente_total');
        $this->declaracion->error_total = collect($this->bloques)->sum('declaracion.error_total');

        $this->declaracion->process($panel->bloques);


        return $this;
    }

    public function panelEnTransaccionesWipOrCheckInterfazWip($panel)
    {
        $jbloques = clone $panel;
        foreach($jbloques->joinBloques as $bloque)
        {

            if(Str::endsWith($panel->inspected_op,"-B"))
            {
                $panel->inspected_op = Str::replaceFirst("-B","",$panel->inspected_op);
            }
            // Verifica en transaccion wip local
//            $verify = new VerificarDeclaracion();
            $interfaz = self::bloqueEnTransaccionWip($bloque->barcode);

           // dd($interfaz);

            $addBloque = new \stdClass();
            $addBloque->bloque = $bloque;

            

            if(isset($interfaz->twip))
            {

                $addBloque->declaracion = $interfaz->declaracion;
                $addBloque->twip = $interfaz->twip;

                // Si esta pendiente o con error...
                if($interfaz->twip->trans_ok != 1)
                {
                    // Verifica en interfaz
//                    $retryVerify = new VerificarDeclaracion();
                    $retryInterfaz = self::bloqueEnInterfazWip($bloque->barcode,$panel->inspected_op);
                    $addBloque->declaracion = $retryInterfaz->declaracion;
                    $addBloque->wip = $retryInterfaz->wip;

                    // Si existe registro Wip, lo replico en TransaccionesWip
                    if(isset($retryInterfaz->wip->id) && $retryInterfaz->wip->trans_ok > 0)
                    {
                        $interfaz->twip->trans_ok = $retryInterfaz->wip->trans_ok;
                        $interfaz->twip->save();
                    }
//                    dd($interfaz);
                }
            } else
            {
//                $verify = new VerificarDeclaracion();
                $interfaz = self::bloqueEnInterfazWip($bloque->barcode,$panel->inspected_op);
                $addBloque->declaracion = $interfaz->declaracion;
                $addBloque->wip = $interfaz->wip;

                // Si existe registro Wip, lo replico en TransaccionesWip
                if(isset($interfaz->wip->id))
                {
                    $twip = new TransaccionWip();
                    $twip->barcode = $bloque->barcode;
                    $twip->trans_id = $interfaz->wip->id;
                    $twip->trans_ok = $interfaz->wip->trans_ok;
                    $twip->trans_det = null;
                    $twip->id_panel = $panel->id;
                    $twip->save();
                }
            }

            $this->bloques[] = $addBloque;
        }


        $this->declaracion->declarado_total = collect($this->bloques)->sum('declaracion.declarado_total');
        $this->declaracion->pendiente_total = collect($this->bloques)->sum('declaracion.pendiente_total');
        $this->declaracion->error_total = collect($this->bloques)->sum('declaracion.error_total');

        $this->declaracion->process($panel->bloques);
        return $this;
    }

    public function bloqueEnInterfazWip($barcode,$op="")
    {
        $w = new Wip();
        $wip = $w->findBarcode($barcode, $op);
        $this->wip = null;

        if(count($wip)>0)
        {
            $this->declaracion->declarado_total = $wip->where('trans_ok','1')->count();
            $this->declaracion->pendiente_total = $wip->where('trans_ok','0')->count();

            $errores = $wip->filter(function ($item, $index) {
                return ((int) $item->trans_ok > 1) ? true : false;
            });

            $this->declaracion->error_total = 0;
            if(count($errores)>0)
            {
                $this->declaracion->error_total = count($errores);
            }

            $this->declaracion->process(1);
            $this->wip = $wip->first();
        }

        return $this;
    }

    public function bloqueEnTransaccionWip($barcode)
    {

        $twip = TransaccionWip::where('barcode',$barcode)->orderBy('created_at','desc')->first();

       

        if ($twip == null)
        {
            $twip = self::bloqueEnInterfazWip($barcode);

          //  dd($twip);

            if(isset($twip->wip))
            {
                $this->declaracion->declarado_total = ($twip->wip->trans_ok == 1) ? 1 : 0;
                $this->declaracion->pendiente_total = ($twip->wip->trans_ok == 0) ? 1 : 0;
                $this->declaracion->error_total = ($twip->wip->trans_ok == 0 || $twip->wip->trans_ok == 1 ) ? 0 : 1;

                $this->declaracion->process(1);

                $this->twip = $twip->wip;
            }
            else
            {
                $this->declaracion->declarado_total = 0;
                $this->declaracion->pendiente_total =0;
                $this->declaracion->error_total = 0;

                $this->declaracion->process(1);

                $this->twip = $twip->wip;
            }

        }
        else {
            $this->declaracion->declarado_total = ($twip->trans_ok == 1) ? 1 : 0;
            $this->declaracion->pendiente_total = ($twip->trans_ok == 0) ? 1 : 0;
            $this->declaracion->error_total = ($twip->trans_ok == 0 || $twip->trans_ok == 1 ) ? 0 : 1;

            $this->declaracion->process(1);

            $this->twip = $twip;
        }


            //dd($twip);

        return $this;
    }

    public function transaccionWipStatusByStocker(Stocker $stocker)
    {
        $query =  DB::connection('aoidata')->select(
            DB::raw("
            select
            tr.trans_ok,
            hib.barcode
            from stocker stk
            -- Obtengo contenido de stocker
            inner join stocker_detalle stkd on stkd.id_stocker = stk.id
            -- Obtengo panele con id_panel
            inner join inspeccion_panel ip on ip.id = stkd.id_panel
            -- Obtengo ultima inspeccion del panel con id_panel
            inner join history_inspeccion_panel hip on hip.id_panel_history = ip.last_history_inspeccion_panel
            -- Obtengo placas de ultima inspeccion
            inner join history_inspeccion_bloque hib on hib.id_panel_history = hip.id_panel_history

            left join transaccion_wip tr on tr.id_panel = ip.id
            where

            stk.barcode  = '$stocker->barcode'
            ")
        );

        return $query;
    }
}