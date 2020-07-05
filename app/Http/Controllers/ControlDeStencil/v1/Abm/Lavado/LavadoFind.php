<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Lavado;

use App\Http\Controllers\ControlDeStencil\v1\Model\Lavado;
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
        $find  = Lavado::orderByDesc('id')->where('codigo',$id)->paginate();
        return $find;
    }
}
