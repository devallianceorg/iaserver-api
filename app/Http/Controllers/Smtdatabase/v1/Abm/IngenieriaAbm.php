<?php

namespace App\Http\Controllers\Smtdatabase\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Model\Ingenieria;
use App\Http\Controllers\Smtdatabase\v1\Request\SMTDatabaseIngenieriaAbmCreateReq;
use App\Http\Controllers\Smtdatabase\v1\Request\SMTDatabaseIngenieriaAbmUpdateReq;

class IngenieriaAbm extends Controller
{

    public function create(SMTDatabaseIngenieriaAbmCreateReq $req)
    {
        $npmpickerdata = Ingenieria::create($req->all());
        return compact('ingenieria');
    }


    public function update(SMTDatabaseIngenieriaAbmUpdateReq $req)
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
