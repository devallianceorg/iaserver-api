<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Tension;

use App\Http\Controllers\ControlDeStencil\v1\Model\Tension;
use App\Http\Controllers\Controller;

class TensionFind extends Controller
{
    public function find() {
        $find = Tension::paginate();
        return $find;
    }

    public function findOperadorId($id) {
        $find  = Tension::where('id_operador',$id)->paginate();
        return $find;
    }

    public function findCodigo($codigo) {
        $find  = Tension::where('codigo',$codigo)->paginate();
        return $find;
    }
}
