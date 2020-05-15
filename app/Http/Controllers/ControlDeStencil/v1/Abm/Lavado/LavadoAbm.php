<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Lavado;

use App\Http\Controllers\ControlDeStencil\v1\Model\Lavado;
use App\Http\Controllers\ControlDeStencil\v1\Request\LavadoCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\LavadoUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LavadoAbm extends Controller
{
    public function show($id) {
        $show = Lavado::findOrFail($id);
        return $show;
    }

    public function create(LavadoCreateReq $req)
    {
        $create = new Lavado();
        $create->id_operador = $req['id_operador'];
        $create->codigo= strtoupper($req['codigo']);

        $create->fecha= Carbon::now();
        $create->hora = Carbon::now();

        $create->save();


        return compact('create');
    }

    public function update(LavadoUpdateReq $req)
    {
        $update = Lavado::find($req->id);
//        $update->columna = $req->valor;
        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = Lavado::where('id',$id)->delete();
        return compact('delete');
    }
}
