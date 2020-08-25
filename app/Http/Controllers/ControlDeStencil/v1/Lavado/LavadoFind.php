<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Lavado;

use App\Http\Controllers\ControlDeStencil\v1\_model\Lavado;
use App\Http\Controllers\Controller;

class LavadoFind extends Controller
{
    public function find() {
        $find = Lavado::orderByDesc('id')->paginate();
        return $find;
    }

    public function byCodigo($codigo) {
        $find  = Lavado::orderByDesc('id')->where('codigo',$codigo)->paginate();
        return $find;
    }

    public function byOperadorId($id) {
        $find  = Lavado::orderByDesc('id')->where('id_operador',$id)->paginate();
        return $find;
    }
}
