<?php
namespace App\Http\Controllers\Trazabilidad\v1\Wip;

use App\Http\Controllers\Trazabilidad\v1\Model\XXEWipITFSerieHistory;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class WipSerieHistory extends WipSerieCommons
{
    public $class = 'App\Http\Controllers\Trazabilidad\v1\Model\XXEWipITFSerieHistory';

    public function findAllBarcodesForPo($op)
    {
        $serie = XXEWipITFSerieHistory::noLock()
            ->select([
                    'referencia_1']
            )
            ->where(function($query){
                return $query->where('organization_code','UP3')
                    ->orWhere('organization_code','UFZ');})
            ->where('NRO_OP',$op)
            ->where('TRANS_OK',1)
            ->get();

        return $serie;
    }

    public function findBarcode($barcode,$op="",$transOk="")
    {
        $serie = XXEWipITFSerieHistory::noLock()
            ->select([
                'id',
                'nro_op',
                'nro_informe',
                'codigo_producto',
                'cantidad',
                'referencia_1',
                'fecha_proceso',
                'trans_ok',
                'ebs_error_desc',
                'ebs_error_trans',
                'fecha_insercion']
        )
            ->where('organization_code','UP3')
            ->where('referencia_1',$barcode);

        if(!empty($op))
        {
            $serie->where('nro_op',$op);
        }

        if(is_numeric($transOk))
        {
            $serie->where('trans_ok',$transOk);
        }

        $result = $serie->orderBy('fecha_insercion','desc')->get();

        return $result;
    }

    public function findBarcodeSecundario($barcode,$op="",$transOk="")
    {
        $serie = XXEWipITFSerieHistory::noLock()
            ->select([
                'id',
                'nro_op',
                'nro_informe',
                'codigo_producto',
                'cantidad',
                'referencia_1',
                'fecha_proceso',
                'trans_ok',
                'ebs_error_desc',
                'ebs_error_trans',
                'fecha_insercion']
        )->where('referencia_1','like',$barcode.'-%');

        if(!empty($op))
        {
            $serie->where('nro_op',$op);
        }

        if(is_numeric($transOk))
        {
            $serie->where('trans_ok',$transOk);
        }

        $serie = $serie->where('organization_code','UP3')
            ->orderBy('fecha_insercion','desc');


        $result = $serie->get();

        //$serie = array_change_key_case($serie,CASE_LOWER);
        return $result;
    }

    public function period($op, $minutes = 60)
    {
        $sql = XXEWipITFSerieHistory::select(
            DB::raw("
                SUM(\"CANTIDAD\") as total,
                nro_op as op,
                DATEPART(YEAR, FECHA_INSERCION) as anio,
                DATEPART(MONTH, FECHA_INSERCION) as mes,
                DATEPART(DAY, FECHA_INSERCION) as dia,
                DATEPART(HOUR, FECHA_INSERCION) as periodo,
                (DATEPART(MINUTE, FECHA_INSERCION) / ".$minutes.") as minuto
            ")
        )
            ->where('nro_op',$op)
            ->groupBy(DB::raw("
                nro_op,
                DATEPART(YEAR, FECHA_INSERCION),
                DATEPART(MONTH, FECHA_INSERCION),
                DATEPART(DAY, FECHA_INSERCION),
                DATEPART(HOUR, FECHA_INSERCION),
                (DATEPART(MINUTE, FECHA_INSERCION) / ".$minutes.")
            "))
            ->orderBy(DB::raw("
                DATEPART(MONTH, FECHA_INSERCION) asc,
                DATEPART(DAY, FECHA_INSERCION) asc,
                DATEPART(HOUR, FECHA_INSERCION)
            "));

        return $sql;
    }
}
