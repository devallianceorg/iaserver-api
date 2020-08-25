<?php

namespace App\Http\Controllers\Npmpicker\v1\Stat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Stat;
use App\Http\Controllers\Npmpicker\v1\_request\StatAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\_request\StatAbmUpdateReq;
use Carbon\Carbon;

class StatAbm extends Controller
{
    public function show($id) {
        $show = Stat::findOrFail($id);
        return $show;
    }

    public function create(StatAbmCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'fecha'=>$now,
            'hora'=>$now
        ]);

        $create = Stat::create($req->all());
        return compact('create');
    }

    public function update(StatAbmUpdateReq $req)
    {
        $item = Stat::findOrFail($req->id);

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
        $item = Stat::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }
}
