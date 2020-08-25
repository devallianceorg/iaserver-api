<?php

namespace App\Http\Controllers\Npmpicker\v1\Pickdata;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Data;
use App\Http\Controllers\Npmpicker\v1\_request\DataAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\_request\DataAbmUpdateReq;
use Carbon\Carbon;

class DataAbm extends Controller
{
    public function show($id) {
        $show = Data::findOrFail($id);
        return $show;
    }

    public function create(DataAbmCreateReq $req)
    {
        $req->merge([
            'hora'=>Carbon::now()
        ]);

        $create = Data::create($req->all());
        return compact('create');
    }

    public function update(DataAbmUpdateReq $req)
    {
        $item = Data::findOrFail($req->id);

        $req->merge([
            'hora'=>Carbon::now()
        ]);

        $update = $item->update($req->all());
        return compact('update');
    }

    public function delete($id)
    {
        $item = Data::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }

}

