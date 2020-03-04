<?php

namespace App\Http\Controllers\Npmpicker\v1\Abm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerStat;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerStatAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\Request\NpmpickerStatAbmUpdateReq;

class NpmpickerStatAbm extends Controller
{

    public function create(NpmpickerStatAbmCreateReq $req)
    {
        $npmpickerstat = NpmpickerStat::create($req->all());
        return compact('npmpickerstat');
    }


    public function update(NpmpickerStatAbmUpdateReq $req)
    {

        $npmpickerstat = NpmpickerStat::find($req->id);

        $npmpickerstat->estado = $req->estado;
        $npmpickerstat->total_error = $req->total_error;
        $npmpickerstat->total_pickup = $req->total_pickup;
        if($req->count !="")
        { $npmpickerstat->count = $req->count; }

        $updated = $npmpickerstat->save();
        
        return compact('updated');
    }

    public function delete($id)
    {
        $deleted = NpmpickerStat::where('id',$id)->delete();
        return compact('deleted');
    }

}
