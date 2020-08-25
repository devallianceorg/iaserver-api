<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Observaciones;

use App\Http\Controllers\ControlDeStencil\v1\_model\Observaciones;
use App\Http\Controllers\Controller;

class ObservacionesFind extends Controller
{
    public function find() {

        $lista = Observaciones::orderByDesc('id')->paginate();
        return $lista;
    }

    public function byOperadorId($id) {
        $lista = Observaciones::where('id_operador',$id)->paginate();
        return $lista;
    }

    public function byCodigoStencil($codigo) {
        $lista = Observaciones::where('codigo',$codigo)->paginate();
        return $lista;
    }
}
