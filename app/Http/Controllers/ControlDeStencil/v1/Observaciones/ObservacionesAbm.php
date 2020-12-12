<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Observaciones;

use App\Http\Controllers\ControlDeStencil\v1\_model\Observaciones;
use App\Http\Controllers\ControlDeStencil\v1\_request\ObservacionesCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\ObservacionesUpdateReq;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\ApiLogin;
use Carbon\Carbon;

class ObservacionesAbm extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api')->except('show');
    }

    public function show($id) {
        $show = Observaciones::findOrFail($id);
        return $show;
    }

    public function create(ObservacionesCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
	    'id_operador' => ApiLogin::user('id'),
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
        if(
            ApiLogin::owner($item->id_operador) ||
            ApiLogin::isAdmin()
        ) {
            $deleted = $item->delete();
            return compact('deleted');
        }

        return ['error'=>'No tiene permiso para eliminar este registro'];
    }
}
