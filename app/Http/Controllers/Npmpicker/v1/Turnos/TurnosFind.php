<?php

namespace App\Http\Controllers\Npmpicker\v1\Turnos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Npmpicker\v1\_model\Turnos;

class TurnosFind extends Controller
{
    public function find() {
        $find = Turnos::paginate();
        return $find;
    }
}
