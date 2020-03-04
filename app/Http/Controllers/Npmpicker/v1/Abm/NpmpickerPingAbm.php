<?php

namespace App\Http\Controllers\Npmpicker\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerPing;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerPingAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerPingAbmUpdateReq;
use Illuminate\Http\Request;

class NpmpickerPingAbm extends Controller
{

    public function create(NpmpickerPingAbmCreateReq $req)
    {
        $npmpickerping = NpmpickerPing::create($req->all());
        return compact('npmpickerping');
    }

    public function update(NpmpickerPingAbmUpdateReq $req)
    {
        if(is_null($req->maquina) || empty($req->maquina))
        { $req->merge(["maquina"=>"N/A"]); }

        $npmpickerping = NpmpickerPing::where('id_linea',$req->id_linea)->where('maquina',$req->maquina)->first();

        if($npmpickerping){
            $npmpickerping->updated = $npmpickerping->update($req->toArray());
            
            return($npmpickerping);
        }
        return compact('npmpickerping');
    }

    public function updateFlag(Request $req)
    {
        if(!$req->has('flag') || is_null($req->flag) || empty($req->flag))
        { $req->merge(["flag"=>null]); }

        $npmpickerping = NpmpickerPing::find($req->id);
        if($npmpickerping){
            $updated = $npmpickerping->update(['flag'=>$req->flag]);
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
