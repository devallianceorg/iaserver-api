<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Armario;

use App\Http\Controllers\ControlDeStencil\v1\Model\Armario;
use App\Http\Controllers\ControlDeStencil\v1\Request\ArmarioCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\ArmarioUpdateReq;
use App\Http\Controllers\Controller;

class ArmarioAbm extends Controller
{
    public function show($id) {
        $show = Armario::find($id);
        return $show;
    }

    public function create(ArmarioCreateReq $req)
    {
        $create = Armario::create($req->all());
        return compact('create');
    }

    public function update(ArmarioUpdateReq $req)
    {
        $update = Armario::find($req->id);
//        $update->columna = $req->valor;
        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = Armario::where('id',$id)->delete();
        return compact('delete');
    }
}
