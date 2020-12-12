<?php

namespace App\Http\Controllers\ControldeCalidad\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControldeCalidad\Model\Cuarentena;
use Illuminate\Support\Facades\DB;


class CuarentenaController extends Controller
{
    public function index()
    {
        $cuarentenas = Cuarentena::from('cuarentena AS c')
            ->select(db::raw(
            'id,
            id_user_calidad,
            motivo,
            tipo,
            id_maquina,
            op,
            created_at,
            updated_at,
            released_at,
            (select count(*) from cuarentena_detalle where id_cuarentena = c.id and released_at is null) as "enCuarentena"
            '))->orderBy('enCuarentena','desc')->get();
        $output = compact('cuarentenas');
        return $output;
    }
}