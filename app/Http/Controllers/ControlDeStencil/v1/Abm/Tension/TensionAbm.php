<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Tension;

use App\Http\Controllers\ControlDeStencil\v1\Model\Tension;
use App\Http\Controllers\ControlDeStencil\v1\Request\TensionCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\TensionUpdateReq;
use App\Http\Controllers\Controller;

class TensionAbm extends Controller
{
    public function show($id) {
        $show = Tension::findOrFail($id);
        return $show;
    }

    public function create(TensionCreateReq $req)
    {
        $create = Tension::create($req->all());
        return compact('create');
    }

    public function update(TensionUpdateReq $req)
    {
        $update = Tension::find($req->id);
//        $update->columna = $req->valor;
        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = Tension::where('id',$id)->delete();
        return compact('delete');
    }
}
