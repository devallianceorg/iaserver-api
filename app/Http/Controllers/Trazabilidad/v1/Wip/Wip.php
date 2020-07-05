<?php
namespace App\Http\Controllers\Trazabilidad\v1\Wip;

use App\Http\Controllers\IAServer\Util;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class Wip extends Controller
{
    public $active = false;
    public $wip_ot = array();
    public $transactions = array();

    /**
     * Estado de OP en WipSerie y WipSerieHistory, obtiene transacciones y resumen de WipOt
     *
     * @param string $op
     * @param bool $withTransactions Default true
     * @return $this
     */
    public function findOp($op, $withTransactions=true, $withPeriod=false)
    {
        $serie = new WipSerie();
        $history = new WipSerieHistory();
        
        $op = str_replace('-B','',$op);
        
        // Obtiene datos de OP Activa
        $wipOt = $this->otInfo($op);

        if ($wipOt) {
            $this->active = true;
            $this->wip_ot = $wipOt;
            if($withTransactions)
            {
                $this->transactions = $this->transactions($op, $wipOt);
            }

            if($withPeriod)
            {
                $this->period = $this->period($op);
                /*$byDateArr = [];
                foreach($this->period as $p)
                {
                    $byDateArr["$p->anio-$p->mes-$p->dia"][] = $p;
                }

                $this->periodByDate = $byDateArr;*/
            }

        } else {
            // La op fue cerrada, muestro detalle de transacciones
            $this->active = false;

            $wipOtTrans = $serie->wipOtInfoFromTransactions($op);
            if ($wipOtTrans) {
                $this->wip_ot = $wipOtTrans;
            } else {
                $this->wip_ot = $history->wipOtInfoFromTransactions($op);
            }

            if($withTransactions)
            {
                $this->transactions = $this->transactions($op);
            }

            if($withPeriod)
            {
                $this->period = $this->period($op);
               /* $byDateArr = [];
                foreach($this->period as $p)
                {
                    $byDateArr["$p->anio-$p->mes-$p->dia"][] = $p;
                }

                $this->periodByDate = $byDateArr;*/
            }
        }

        return $this;
    }

    public function findAllBarcodes($op)
    {
        $lista =[];
        $serie = new WipSerie();
        $history = new WipSerieHistory();

        $listaSerie = $serie->findAllBarcodesForPo($op);
        $listaHistory = $serie->findAllBarcodesForPo($op);


    }

    /**
     * Localiza un barcode en WipSerie y WipSerieHistory
     *
     * @param string $barcode
     * @param string $op
     * @param string $trans_ok
     * @return mixed
     */
    public function findBarcode($barcode, $op="", $trans_ok="")
    {
        $serie = new WipSerie();
        $history = new WipSerieHistory();

        $wip_serie = $serie->findBarcode($barcode,$op,$trans_ok);
        if(!count($wip_serie))
        {
            $wip_serie = $history->findBarcode($barcode,$op,$trans_ok);
        }

        return $wip_serie;
    }

    public function findBarcodeSecundario($barcode, $op="",$trans_ok="")
    {
        $serie = new WipSerie();
        $history = new WipSerieHistory();

        $wip_serie = $serie->findBarcodeSecundario($barcode,$op,$trans_ok);
        if(!count($wip_serie))
        {
            $wip_serie = $history->findBarcodeSecundario($barcode,$op,$trans_ok);
        }

        return $wip_serie;
    }

    /**
     * Obtiene el periodo de inspecciones en WipSerie y WipSerieHistory por un rango de minutos
     * por defecto el rango es cada 60 minutos
     *
     * @param $op
     * @param int $minutes
     * @return mixed
     */
    public function period($op,$minutes=60)
    {
        $serie = new WipSerie();
        $history = new WipSerieHistory();

        $serie = $serie->period($op,$minutes)->get();
        $history = $history->period($op,$minutes)->get();

        $serie = Util::doMerge($serie,$history,[
            'op','anio','mes','dia','periodo','minuto'
        ]);

        // Reordena el periodo por mes / dia
        $sorted = multipleSort($serie,[
            'mes'=>'asc',
            'dia'=>'asc',
            'periodo'=>'asc'
        ]);

        return $sorted;
    }


    /**
     * Analiza todas las transacciones realizadas para una OP en WipSerie y en WipSerieHistory
     *
     * @param strig $op OP-12345
     * @return object
     */
    public function transactions($op, $wipOt = null)
    {
        $wip = new WipSerie();
        $wiph = new WipSerieHistory();

        $wip_serie = $wip->transactionResume($op);
        $wip_history = $wiph->transactionResume($op);

        $arr_merge = collect(array_merge($wip_serie->toArray() ,$wip_history->toArray()));

        $solicitudes = $arr_merge->sum('total');
        $declaradas = $arr_merge->where('ebs_error_trans',null)->where('trans_ok','1')->sum('total');
        $pendientes = $arr_merge->where('trans_ok','0')->sum('total');

        $arr_errores = $arr_merge->whereNotNull('ebs_error_trans');
        // $arr_errores = Arr::where($arr_merge, function($key, $value)
        // {
        //     $value = (object) $value;
        //     if($value->ebs_error_trans != null || $value->trans_ok > 1 ) return $value;
        // });

        $errores = collect($arr_errores)->sum('total');

        $mode = null;
        $modedeclare = null;

        if($wipOt!=null) {
            // La cantidad declarada supera el start_quantity
            if ($declaradas >= $wipOt->start_quantity) {
                $mode = 'seriefull';
            } else {
                if ($pendientes == 0) {
                    $modedeclare = true;
                    $mode = 'insert';
                } else {
                    if (
                        ($declaradas + $pendientes) >= $wipOt->start_quantity
                    ) {
                        $modedeclare = true;
                        $mode = 'seriefullwithpendients';
                    } else {
                        $modedeclare = true;
                        $mode = 'insertwithpendients';
                    }
                }
            }
        }

        $result = (object) array(
            'mode' => $mode,
            'modedeclare' => $modedeclare,
            'solicitudes' => $solicitudes,
            'declaradas' => $declaradas,
            'pendientes' => $pendientes,
            'errores' => $errores,
            'detail' => (object) compact('wip_serie','wip_history')
        );

        return $result;
    }

    /**
     * Obtiene datos de OP abierta en XXEWipOt
     *
     * @param string $op OP-12345
     * @return mixed
     */
    public function otInfo($op)
    {
        $wipot = WipOt::findOp($op);
        return $wipot;
    }

    /**
     * Declara un semielaborado en XXEWipITFSerie
     *
     * @param string $organization UP3
     * @param string $op OP-12345
     * @param string $semielaborado 4-651-MEM4356231
     * @param int $cantidad 1
     * @param string $referencia Puede ser el barcode de un panel
     * @return XXEWipITFSerie
     */
    public function declarar($organization,$op,$semielaborado,$cantidad,$referencia="")
    {
        $wipserie = new WipSerie();
        return $wipserie->declarar($organization,$op,$semielaborado,$cantidad,$referencia);
    }

    public function declared($referencia,$op)
    {
        $wipserie = new WipSerie();
        $result = $wipserie->findBarcode($referencia,$op);

        if($result!=null && count($result)>0)
        {
            return $result->first();
        } else
        {
            return false;
        }
    }
}
