<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Lavado;

use App\Http\Controllers\ControlDeStencil\v1\_model\Lavado;
use App\Http\Controllers\ControlDeStencil\v1\_request\LavadoCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\LavadoUpdateReq;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LavadoAbm extends Controller
{
    public function show($id) {
        $show = Lavado::findOrFail($id);
        return $show;
    }

    public function create(LavadoCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'codigo'=> strtoupper($req->codigo),
            'fecha' => $now,
            'hora' => $now,
        ]);

        $create = Lavado::create($req->all());
        return compact('create');
    }

    public function update(LavadoUpdateReq $req)
    {
        $item = Lavado::findOrFail($req->id);

        $now = Carbon::now();
        $req->merge([
            'hora'=>$now,
            'fecha'=>$now
        ]);

        if($req->has('codigo')) {
            $req->merge(['codigo'=> strtoupper($req->codigo)]);
        }

        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Lavado::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
