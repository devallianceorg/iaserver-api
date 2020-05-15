<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Observaciones;

use App\Http\Controllers\ControlDeStencil\v1\Model\Observaciones;
use App\Http\Controllers\ControlDeStencil\v1\Request\ObservacionesCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\ObservacionesUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ObservacionesAbm extends Controller
{
    public function show($id) {
        $show = Observaciones::findOrFail($id);
        return $show;
    }

    public function create(ObservacionesCreateReq $req)
    {   
        $create = new Observaciones();
        $create->id_operador = $req['id_operador'];
        $create->codigo= $req['codigo'];
        $create->texto = $req['texto'];

        $create->fecha= Carbon::now();
        $create->hora = Carbon::now();

        $create->save();

        return compact('create');
    }

    public function update(ObservacionesUpdateReq $req)
    {
        $update = Observaciones::find($req->id);

//        $stencil->columna = $req->valor;

        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = Observaciones::where('id',$id)->delete();
        return compact('delete');
    }
}
