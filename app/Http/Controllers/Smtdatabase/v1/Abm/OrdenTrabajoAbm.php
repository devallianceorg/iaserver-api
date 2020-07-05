<?php

namespace App\Http\Controllers\Smtdatabase\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Model\OrdenTrabajo;
use App\Http\Controllers\Smtdatabase\v1\Request\OrdenTrabajoAbmCreateReq;
use App\Http\Controllers\Smtdatabase\v1\Request\OrdenTrabajoAbmUpdateReq;

class OrdenTrabajoAbm extends Controller
{

    public function create(OrdenTrabajoAbmCreateReq $req)
    {
        $ordentrabajo = OrdenTrabajo::create($req->all());
        return compact('ordentrabajo');
    }


    public function update(OrdenTrabajoAbmUpdateReq $req)
    {

        $ordentrabajo = OrdenTrabajo::find($req->id);

        $ordentrabajo->modelo = $req->modelo;
        $ordentrabajo->lote = $req->lote;
        $ordentrabajo->panel = $req->panel;
        $ordentrabajo->semielaborado = $req->semielaborado;
        $ordentrabajo->qty = $req->qty;

        $updated = $ordentrabajo->save();
        
        return compact('updated');
    }

    public function delete($id)
    {
        $deleted = OrdenTrabajo::where('id',$id)->delete();
        return compact('deleted');
    }

}
