<?php
namespace IAServer\Http\Controllers\Aoicollector\Api\Andon;

use IAServer\Http\Controllers\Aoicollector\Model\Stocker;
use IAServer\Http\Controllers\Aoicollector\Stocker\Trazabilidad\TrazaStocker;
use IAServer\Http\Controllers\SMTDatabase\SMTDatabase;
use IAServer\Http\Controllers\Trazabilidad\Declaracion\Wip\Wip;
use IAServer\Http\Requests;
use Illuminate\Support\Facades\Response;
use IAServer\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
set_time_limit(400);

class ControllerAndonApi extends Controller
{

    public function data($barcode) {

        $toResume = new \stdClass();
        $fecha = Carbon::now();
        $date = $fecha->format('Y-m-d');

        $query = DB::table('aoidata.produccion as t1')
       ->join('aoidata.maquina as t2', 't1.id_maquina', '=', 't2.id')
       ->select(DB::raw('GROUP_CONCAT(t1.id_maquina) as idConcat'), DB::raw('GROUP_CONCAT(t1.barcode) as maquinaConcat'), DB::raw('GROUP_CONCAT(t2.maquina) as maquina'))
       ->where('t1.barcode','like',"%".$barcode."%")
       ->get();

    if(!empty($query)) {

        $idMaquina  = $query[0]->idConcat;
        $producLine = $this->getProducLine($idMaquina, $date);

        if(count($producLine) > 0) {

            $op         = $producLine[0]->inspected_op;
            $op_format  = $producLine[0]->op_new;
            $linea      = $producLine[0]->linea;
            $turno      = $producLine[0]->turno;

            $query2             = $this->topRechazo($idMaquina, $op, $turno, $date);
            $realFalse          = $this->RealFalso($idMaquina, $op, $turno, $date);
            $despachoDay        = $this->DespachoDay($op_format,$turno,$date);
            $despachoGeneralOP  = $this->DespachoGeneralOP($op_format);
            $prodGeneralOP      = $this->prodGeneralOP($op_format);

            $warning            = $this->getWarning($idMaquina, $op, $turno, $date);

            $toResume->produccion         = $producLine;
            $toResume->toprechazo         = $query2;
            $toResume->realfalso          = $realFalse;
            $toResume->despachoDay        = $despachoDay;
            $toResume->despachoGeneralOP  = $despachoGeneralOP;
            $toResume->prodGeneralOP      = $prodGeneralOP;

            $toResume->warning            = $warning;

        }
        else {
            $toResume->status = 0;
            $toResume->barcode = $query[0]->maquina;
        }

    } else {
        $toResume->status = 0;
        $toResume->barcode = $query[0]->maquina;
    }
     
    return $toResume;

    }

    public function info($barcode, $date) {

        $toResume = new \stdClass();
        // $fecha = Carbon::now();
        // $date = $fecha->format('Y-m-d');

        $code = str_replace_first("-B","", $barcode);

        $query = DB::table('aoidata.produccion')
        ->select(DB::raw('GROUP_CONCAT(id_maquina) as idConcat'), DB::raw('GROUP_CONCAT(barcode) as maquinaConcat'))
        ->where('barcode','like',"%".$code."%")
        ->get();

        if(!empty($query)) {

            $idMaquina  = $query[0]->idConcat;
            $producLine = $this->getProducLine($idMaquina, $date);

            if(count($producLine) > 0) {

                $op         = $producLine[0]->inspected_op;
                $op_format  = $producLine[0]->op_new;
                $linea      = $producLine[0]->linea;
                $turno      = $producLine[0]->turno;

                $query2             = $this->topRechazo($idMaquina, $op, $turno, $date);
                $realFalse          = $this->RealFalso($idMaquina, $op, $turno, $date);
                $despachoDay        = $this->DespachoDay($op_format,$turno,$date);
                $despachoGeneralOP  = $this->DespachoGeneralOP($op_format);
                $prodGeneralOP      = $this->prodGeneralOP($op_format);

              

                $toResume->produccion         = $producLine;
                $toResume->toprechazo         = $query2;
                $toResume->realfalso          = $realFalse;
                $toResume->despachoDay        = $despachoDay;
                $toResume->despachoGeneralOP  = $despachoGeneralOP;
                $toResume->prodGeneralOP      = $prodGeneralOP;

              

            }
            else {
                $toResume->status = 0;
            }

        } else {
            $toResume->status = 0;
        }
        
        return Response::json($toResume);

    }

    public function getWarning($idMaquina, $op, $turno, $data) {

        $query = DB::select("CALL aoidata.sp_warning_hour('".$idMaquina."','".$op."','".$turno."','".$data."')");
        return $query;

    }

    public function getProducLine($idMaquina, $data) {
        $query = DB::select("CALL aoidata.sp_production('".$idMaquina."','".$data."')");
        return $query;
    }

    public function getLineAll() {
        $query = DB::table('aoidata.maquina as t1')
                        ->leftJoin('aoidata.produccion as t2','t1.id','=','t2.id_maquina')
                        ->select('t1.id','t1.maquina','t1.linea','t2.barcode','t2.op')    
                        ->where('t1.active','=','1')
                        ->orderby('t1.linea', 'asc')
                        ->groupby('t1.linea')
                        ->get();

        return Response::json($query);
    }

    public function RealFalso($idMaquina, $op, $turno, $data) {
        $query = DB::select("CALL aoidata.sp_production_andon_realFalso('".$idMaquina."','".$op."','".$turno."','".$data."')");
        return $query;
    }

    public function DespachoDay($op, $turno, $date) {
        if($turno == 'M'){$turno = 'Mañana';} else if($turno == 'T'){$turno = 'Tarde';} else if($turno == 'N'){$turno = 'Noche';}
        $query = DB::table('placas_dev.datos as t1')
                        ->leftjoin('placas_dev.turno as t2','t1.id_turno','=','t2.id')                   
                        ->select(DB::raw('sum(t1.cantidad) as total'), 't1.op', 't2.turno')
                        ->where('t1.op','=',$op)
                        ->where('t2.turno','=',$turno)
                        ->where('t1.fecha','=',$date)
                        ->groupby('t1.op')
                        ->get();
        return $query;
    }

    public function prodGeneralOP($op) {
                        $query = DB::table('aoidata.inspeccion_panel as t1')                 
                        ->select(DB::raw('(count(t1.panel_barcode) * t1.bloques) as total'), 't1.inspected_op', 't1.bloques')
                        ->where('t1.inspected_op','=',$op)
                        ->where('t1.revision_ins','=','OK')
                        ->groupby('t1.inspected_op')
                        ->get();    
        return $query;
    }

    public function DespachoGeneralOP($op) {
        $query = DB::table('placas_dev.datos as t1')                 
                        ->select(DB::raw('sum(t1.cantidad) as total'), 't1.op')
                        ->where('t1.op','=',$op)
                        ->groupby('t1.op')
                        ->get();
        return $query;
    }

    public function topRechazo($idMaquina, $op, $turno, $data) {
        $query = DB::select("CALL aoidata.sp_production_andon_top_rechazo('".$idMaquina."','".$op."','".$turno."','".$data."')");
        return $query;
    }

}