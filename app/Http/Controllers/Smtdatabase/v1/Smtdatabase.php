<?php

namespace App\Http\Controllers\Smtdatabase\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Model\Ingenieria;
use App\Http\Controllers\Smtdatabase\v1\Model\Materiales;
use App\Http\Controllers\Smtdatabase\v1\Model\MaterialIndex;
use App\Http\Controllers\Smtdatabase\v1\Model\OrdenTrabajo;
use App\Http\Controllers\Smtdatabase\v1\Request\SmtdatabaseOrdenTrabajoUpdateReq;

class Smtdatabase extends Controller
{
    public function index()
    {
        $name = 'Smtdatabase';
        $version = 'v1';

        $output = compact('name','version');
    	return $output;
    }

    public function QueryModels()
    {
        return Ingenieria::select('modelo')
                        ->whereRaw('length(modelo) >= ?',[3])
                        ->groupBy('modelo')
                        ->orderBy('modelo')->get();
    }

    public function QueryBatch($modelo)
    {
        return Ingenieria::select('lote')
                        ->where('modelo',$modelo)
                        ->groupBy('lote')
                        ->orderBy('lote')->get();
    }

    public function IncProductionOpBy(SmtdatabaseOrdenTrabajoUpdateReq $req)
    {
        $updated = false;
        $op = OrdenTrabajo::where('op',$req->op)->first();
        
        if($op)
        {
            if($req->modo == 'man')
            { $op->prod_man = $op->prod_man + $req->total; }
            else if($req->modo == 'aoi')
            { $op->prod_aoi = $op->prod_aoi + $req->total; }
            
            $updated = $op->save();
        }

        return compact('updated');
    }

    public function ModeloLoteByMaterialId($id_material)
    {
        return Materiales::select('i.modelo','i.lote')
                        ->join('material_index mi','mi.id_material','=',$id_material)
                        ->join('ingenieria i','i.id','=','mi.id_ingenieria')
                        ->where('mi.id',$id_material)
                        ->orderBy('modelo','DESC')->get();
    }

    public function QueryDesc($partNumber,$modelo,$lote)
    {
        return Materiales::select('m.descripcion_componente')
                        ->from('materiales as m')
                        ->leftJoin('material_index mi','mi.id_material','m.id')
                        ->leftJoin('ingenieria i','i.id','mi.id_ingenieria')
                        ->where('m.componente',$partNumber)
                        ->where('i.modelo',$modelo)
                        ->where('i.lote','like','%'.$lote.'%')
                        ->orderBy('i.modelo','DESC')->get();
    }

    public function CheckMaterial($add_comp,$add_logop,$add_asignacion)
    {
        $select_var = 0;

        $query = Materiales::select('id')
                            ->where('componente',$add_comp)
                            ->where('logop',$add_logop)
                            ->where('asignacion',$add_asignacion)
                            ->orderBy('id','DESC')->first();
        if(count($query) > 0)
        {
            $select_var = $query;
        }
        return $select_var;
    }

    public function CheckPcb($logop,$descripcion,$asignacion)
    {
        $posiblePcb = 0;
        
    }
}
