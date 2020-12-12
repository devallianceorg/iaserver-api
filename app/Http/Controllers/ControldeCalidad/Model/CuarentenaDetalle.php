<?php

namespace App\Http\Controllers\Cuarentena\Model;

use Illuminate\Database\Eloquent\Model;

class CuarentenaDetalle extends Model
{
    protected $table = 'cuarentena_detalle';
    protected $connection = 'aoidata';
    public $timestamps = false;

    public function joinCuarentena()
    {
        return $this->hasOne('App\Http\Controllers\Cuarentena\Model\Cuarentena', 'id', 'id_cuarentena');
    }
}
