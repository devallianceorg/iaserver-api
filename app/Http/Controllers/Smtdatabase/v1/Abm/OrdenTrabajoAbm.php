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
        $npmpickerdata = OrdenTrabajo::create($req->all());
        return compact('ordentrabajo');
    }


    public function update(OrdenTrabajoAbmUpdateReq $req)
    {

        $npmpickerdata = Ingenieria::find($req->id);

        $npmpickerdata->id_stat = $req->id_stat;
        $npmpickerdata->total_error = $req->total_error;
        $npmpickerdata->total_pickup = $req->total_pickup;
        $npmpickerdata->hora = $req->hora;
        $npmpickerdata->inspeccion = $req->inspeccion;
        $npmpickerdata->ajuste = $req->ajuste;

        $updated = $npmpickerdata->save();
        
        return compact('updated');
    }

    public function delete($id)
    {
        $deleted = Ingenieria::where('id',$id)->delete();
        return compact('deleted');
    }

}
