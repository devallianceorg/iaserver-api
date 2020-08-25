<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Armario;

use App\Http\Controllers\ControlDeStencil\v1\_model\Armario;
use App\Http\Controllers\ControlDeStencil\v1\_request\ArmarioCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\_request\ArmarioUpdateReq;
use App\Http\Controllers\Controller;

class ArmarioAbm extends Controller
{
    public function show($id) {
        $show = Armario::findOrFail($id);
        return $show;
    }

    public function create(ArmarioCreateReq $req)
    {
        $create = Armario::create($req->all());
        return compact('create');
    }

    public function update(ArmarioUpdateReq $req)
    {
        $item = Armario::findOrFail($req->id);
        $updated = $item->update($req->all());
        return compact('updated');
    }

    public function delete($id)
    {
        $item = Armario::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
