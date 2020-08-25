<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Ubicacion;

use App\Http\Controllers\ControlDeStencil\v1\_model\StencilUbicacion;
use App\Http\Controllers\ControlDeStencil\v1\_request\UbicacionCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\UbicacionUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UbicacionAbm extends Controller
{
    public function show($id) {
        $show = StencilUbicacion::findOrFail($id);
        return $show;
    }

    public function create(UbicacionCreateReq $req)
    {
        // Busca el codigo, de encontrarlo procede a eliminar su ubicacion.
        $exist = StencilUbicacion::whereCodigo($req->codigo)->first();
        if($exist) {
           $exist->delete();
        }

        // Crea la nueva ubicacion
        $create = StencilUbicacion::create($req->all());
        return compact('create');
    }

    public function update(UbicacionUpdateReq $req)
    {
        $item = StencilUbicacion::findOrFail($req->id);
        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = StencilUbicacion::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
