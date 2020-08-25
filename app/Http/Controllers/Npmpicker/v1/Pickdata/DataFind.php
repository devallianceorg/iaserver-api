<?php

namespace App\Http\Controllers\Npmpicker\v1\Pickdata;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Data;

class DataFind extends Controller
{
    public function find() {
        $find = Data::paginate();
        return $find;
    }

    public function byIdStat($id_stat) {
        $data = Data::where('id_stat',$id_stat)->get();
        return compact('data');
    }
}
