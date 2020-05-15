<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Observaciones;

use App\Http\Controllers\ControlDeStencil\v1\Model\Observaciones;
use App\Http\Controllers\Controller;
use App\User;

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
