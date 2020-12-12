<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Stencil;

use App\Http\Controllers\ControlDeStencil\v1\_model\Stencil;
use App\Http\Controllers\Controller;

class StencilFind extends Controller
{
    public function find() {

        $codigo = request('codigo');
        $keyword = request('keyword');

        if($codigo!=null) {
            $lista = Stencil::where('codigo',$codigo)->orderByDesc('id')->paginate();
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
		->orderByDesc('id')
                ->paginate();
            return $lista;
        }

        $lista = Stencil::orderByDesc('id')->paginate();
        return $lista;
    }

    public function findCodigo($codigo) {
        $stencil = Stencil::where('codigo',$codigo)->firstOrFail();
        return $stencil;
    }
}
