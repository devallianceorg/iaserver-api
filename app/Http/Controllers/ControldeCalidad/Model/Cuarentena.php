<?php

namespace App\Http\Controllers\ControldeCalidad\Model;

use Illuminate\Database\Eloquent\Model;

class Cuarentena extends Model
{
    protected $table = 'cuarentena';
    protected $connection = 'aoidata';
    public $timestamps = false;

    public function joinUser()
    {
        return $this->hasOne('App\User', 'id', 'id_user_calidad');
    }

    public function joinDetail()
    {
        return $this->hasMany('App\Http\Controllers\Cuarentena\Model\CuarentenaDetalle', 'id_cuarentena', 'id');
    }

    public function countTotal() {
        return $this->joinDetail()->count();
    }

    public function countCuarentena() {
        return $this->joinDetail()
            ->where('released_at',null)
            ->count();
    }

    public function countReleased() {
        return $this->joinDetail()
            ->where('released_at','<>',null)
            ->count();
    }
}
