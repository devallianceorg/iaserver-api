<?php

namespace App\Http\Controllers\Npmpicker\v1\Stat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Stat;
use Carbon\Carbon;

class StatFind extends Controller
{
    public function find() {
        $find = Stat::paginate();
        return $find;
    }

    public function getFeeders($fecha=null,$id_linea,$turno='M',$estado=null) {
        if($fecha==null) {
            $fecha = Carbon::now()->toDateString();
        }

        $feeders = Stat::where('fecha',$fecha)
            ->where('id_linea',$id_linea)
            ->where('turno',$turno);

        if($estado) {
            $feeders->where('estado',$estado);
        }

        $feeders = $feeders->with('detail')->get();

        return compact('feeders');
    }

}
