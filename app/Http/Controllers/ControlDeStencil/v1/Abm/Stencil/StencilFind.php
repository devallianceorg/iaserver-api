<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Stencil;

use App\Http\Controllers\ControlDeStencil\v1\Model\Stencil;
use App\Http\Controllers\Controller;

class StencilFind extends Controller
{
    public function find() {

        $codigo = request('codigo');
        $keyword = request('keyword');

        if($codigo!=null) {
            $lista = Stencil::where('codigo',$codigo)->paginate();
            return $lista;
        }

        if($keyword!=null) {
            $lista = Stencil::where('codigo',$keyword)
                ->orWhere('modelo','like',"%$keyword%")
                ->orWhere('placa','like',"%$keyword%")
                ->orWhere('lado','like',"%$keyword%")
                ->orWhere('serie','like',"%$keyword%")
                ->orWhere('job',$keyword)
                ->orWhere('pcb','like',"%$keyword%")
                ->orWhere('cliente','like',"%$keyword%")
                ->paginate();
            return $lista;
        }

        $lista = Stencil::paginate();
        return $lista;
    }

    public function findCodigo($codigo) {
        $stencil = Stencil::where('codigo',$codigo)->firstOrFail();
        return $stencil;
    }
}
