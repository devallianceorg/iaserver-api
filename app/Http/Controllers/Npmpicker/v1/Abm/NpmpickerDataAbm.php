<?php

namespace App\Http\Controllers\Npmpicker\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerData;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerDataAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerDataAbmUpdateReq;

class NpmpickerStatAbm extends Controller
{

    public function create(NpmpickerDataAbmCreateReq $req)
    {
        $npmpickerdata = NpmpickerData::create($req->all());
        return compact('npmpickerdata');
    }


    public function update(NpmpickerDataAbmUpdateReq $req)
    {

        $npmpickerdata = NpmpickerData::find($req->id);

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
        $deleted = NpmpickerData::where('id',$id)->delete();
        return compact('deleted');
    }

}
