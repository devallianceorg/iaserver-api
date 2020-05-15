<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Stencil;

use App\Http\Controllers\ControlDeStencil\v1\Model\Stencil;
use App\Http\Controllers\ControlDeStencil\v1\Request\StencilCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\StencilUpdateReq;
use App\Http\Controllers\Controller;

class StencilAbm extends Controller
{
    public function show($id) {
        $show = Stencil::find($id);
        return $show;
    }

    public function create(StencilCreateReq $req)
    {
        $stencil = Stencil::create($req->all());
        return compact('stencil');
    }

    public function update(StencilUpdateReq $req)
    {
        $stencil = Stencil::find($req->id);

//        $stencil->columna = $req->valor;

        $updated = $stencil->save();
        
        return compact('updated');
    }

    public function delete($id)
    {
        $deleted = Stencil::where('id',$id)->delete();
        return compact('deleted');
    }
}
