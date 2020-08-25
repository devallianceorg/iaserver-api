<?php

namespace App\Http\Controllers\Npmpicker\v1\Turnos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Turnos;
use App\Http\Controllers\Npmpicker\v1\_request\TurnosAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\_request\TurnosAbmUpdateReq;

class TurnosAbm extends Controller
{
    public function show($id) {
        $show = Turnos::findOrFail($id);
        return $show;
    }

    public function create(TurnosAbmCreateReq $req)
    {
        $create = Turnos::create($req->all());
        return compact('create');
    }

    public function update(TurnosAbmUpdateReq $req)
    {
        $item = Turnos::findOrFail($req->id);
        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Turnos::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }

}
