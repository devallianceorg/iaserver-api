<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Tension;

use App\Http\Controllers\ControlDeStencil\v1\_model\Tension;
use App\Http\Controllers\ControlDeStencil\v1\_request\TensionCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\TensionUpdateReq;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\ApiLogin;
use Carbon\Carbon;

class TensionAbm extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api')->except('show');
    }

    public function show($id) {
        $show = Tension::findOrFail($id);
        return $show;
    }

    public function create(TensionCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'id_operador' => ApiLogin::user('id'),
            'fecha' => $now,
        ]);

        $create = Tension::create($req->all());
        return compact('create');
    }

    public function update(TensionUpdateReq $req)
    {
        $item = Tension::findOrFail($req->id);

        $now = Carbon::now();
        $req->merge([
            'fecha'=>$now
        ]);

        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Tension::findOrFail($id);
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
