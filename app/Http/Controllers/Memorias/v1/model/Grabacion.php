<?php

namespace App\Http\Controllers\Memorias\v1\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grabacion extends Model
{
    protected $connection = 'memorias';
    protected $table = 'grabacion';

    public function operador()
    {
        return $this->hasOne('App\User','id','id_usuario');
    }

    public function scopeTransPendiente()
    {
        return $this->where('traza_code','0')->get();
    }

    public static function filtroFecha($fechaFrom,$fechaTo)
    {
        return self::whereRaw(DB::raw(" DATE(fecha) between '".$fechaFrom."' and '".$fechaTo."'"));
    }
}
