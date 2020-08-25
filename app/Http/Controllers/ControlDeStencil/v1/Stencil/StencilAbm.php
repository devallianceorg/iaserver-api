<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Stencil;

use App\Http\Controllers\ControlDeStencil\v1\_model\Stencil;
use App\Http\Controllers\ControlDeStencil\v1\_request\StencilCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\StencilUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class StencilAbm extends Controller
{
    public function show($id) {
        $show = Stencil::findOrFail($id);
        return $show;
    }

    public function create(StencilCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'ingreso' => $now,
            'usos' => 0,
        ]);

        $create = Stencil::create($req->all());
        return compact('create');
    }

    public function update(StencilUpdateReq $req)
    {
        $item = Stencil::findOrFail($req->id);
        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Stencil::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
