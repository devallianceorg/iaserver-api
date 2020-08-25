<?php

namespace App\Http\Controllers\Npmpicker\v1\Ping;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Ping;
use App\Http\Controllers\Npmpicker\v1\_request\PingAbmCreateReq;
use App\Http\Controllers\Npmpicker\v1\_request\PingAbmUpdateReq;
use Carbon\Carbon;

class PingAbm extends Controller
{
    public function show($id) {
        $show = Ping::findOrFail($id);
        return $show;
    }

    public function create(PingAbmCreateReq $req)
    {
        $now = Carbon::now();
        $req->merge([
            'ping'=>$now,
            'updated_at'=>$now
        ]);

        $create = Ping::create($req->all());
        return compact('create');
    }

    public function update(PingAbmUpdateReq $req)
    {
        $item = Ping::findOrFail($req->id);

        $now = Carbon::now();
        $req->merge([
            'ping'=>$now,
            'updated_at'=>$now
        ]);

        $update = $item->update($req->all());
        return compact('update');
    }

    public function delete($id)
    {
        $item = Ping::findOrFail($id);
        $deleted = $item->delete();
        return compact('deleted');
    }

}
