<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Ubicacion;

use App\Http\Controllers\ControlDeStencil\v1\_model\StencilUbicacion;
use App\Http\Controllers\Controller;

class UbicacionFind extends Controller
{
    public function find() {
        $find = StencilUbicacion::paginate();
        return $find;
    }

    public function findCodigo($codigo) {
        $find  = StencilUbicacion::where('codigo',$codigo)->firstOrFail();
        return $find;
    }
}
