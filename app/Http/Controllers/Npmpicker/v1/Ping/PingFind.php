<?php

namespace App\Http\Controllers\Npmpicker\v1\Ping;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Ping;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PingFind extends Controller
{
    public function find() {
        $find = Ping::paginate();
        return $find;
    }

    public function byLinea($fecha=null) {
        if($fecha==null) {
            $fecha = Carbon::now()->toDateString();
        }

        $stat = Ping::whereDate('ping',$fecha)->get();

        $linea = $stat->groupBy('id_linea');
        return compact('linea');
    }

}
