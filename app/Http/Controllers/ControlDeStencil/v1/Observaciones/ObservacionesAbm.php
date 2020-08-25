<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Observaciones;

use App\Http\Controllers\ControlDeStencil\v1\_model\Observaciones;
use App\Http\Controllers\ControlDeStencil\v1\_request\ObservacionesCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\ObservacionesUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ObservacionesAbm extends Controller
{
    public function show($id) {
        $show = Observaciones::findOrFail($id);
        return $show;
    }

    public function create(ObservacionesCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'fecha' => $now,
            'hora' => $now,
        ]);

        $create = Observaciones::create($req->all());
        return compact('create');
    }

    public function update(ObservacionesUpdateReq $req)
    {
        $item = Observaciones::findOrFail($req->id);

        $now = Carbon::now();
        $req->merge([
            'hora'=>$now,
            'fecha'=>$now
        ]);

        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Observaciones::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
