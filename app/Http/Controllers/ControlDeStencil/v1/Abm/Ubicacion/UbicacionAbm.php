<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Ubicacion;

use App\Http\Controllers\ControlDeStencil\v1\Model\StencilUbicacion;
use App\Http\Controllers\ControlDeStencil\v1\Request\UbicacionCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\UbicacionUpdateReq;
use App\Http\Controllers\Controller;

class UbicacionAbm extends Controller
{
    public function show($id) {
        $show = StencilUbicacion::findOrFail($id);
        return $show;
    }

    public function create(UbicacionCreateReq $req)
    {
        $create = StencilUbicacion::create($req->all());
        return compact('create');
    }

    public function update(UbicacionUpdateReq $req)
    {
        $update = StencilUbicacion::find($req->id);
//        $update->columna = $req->valor;
        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = StencilUbicacion::where('id',$id)->delete();
        return compact('delete');
    }
}
