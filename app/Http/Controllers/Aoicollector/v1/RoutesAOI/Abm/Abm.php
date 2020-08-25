<?php

namespace App\Http\Controllers\Aoicollector\v1\RoutesAOI;

use App\Http\Controllers\ControlDeStencil\v1\Model\AoiRoutes;
use App\Http\Controllers\ControlDeStencil\v1\Request\AoiRoutesCreateReq;
use App\Http\Controllers\ControlDeStencil\v1\Request\AoiRoutesUpdateReq;
use App\Http\Controllers\Controller;

class RoutesAbm extends Controller
{
    public function show($id) {
        $show = AoiRoutes::find($id);
        return $show;
    }

    public function create(AoiRoutesCreateReq $req)
    {
        $create = AoiRoutes::create($req->all());
        return compact('create');
    }

    public function update(AoiRoutesUpdateReq $req)
    {
        $update = AoiRoutes::find($req->id);
//        $update->columna = $req->valor;
        $update = $update->save();
        
        return compact('update');
    }

    public function delete($id)
    {
        $delete = AoiRoutes::where('id',$id)->delete();
        return compact('delete');
    }
}
