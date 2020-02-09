<?php

namespace App\Http\Controllers\Npmpicker\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerPing;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerPingAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerPingAbmUpdateReq;

class NpmpickerPingAbm extends Controller
{

    public function create(NpmpickerPingAbmCreateReq $req)
    {
        $npmpickerping = NpmpickerPing::create($req->all());
        return compact('npmpickerping');
    }

    public function update(NpmpickerPingAbmUpdateReq $req)
    {
        $linea = $req->id_linea;
        $maquina = $req->maquina;

        $npmpickerping = NpmpickerPing::where('id_linea',$linea)->where('maquina',$maquina)->first();

        if($npmpickerping){
            $updated = $npmpickerping->update($req->toArray());
            return ['updated'=>$updated];
        }
        return compact('npmpickerping');
    }

    public function delete($id)
    {
        $deleted = NpmpickerPing::where('id',$id)->delete();
        return compact('deleted');

    }

}
