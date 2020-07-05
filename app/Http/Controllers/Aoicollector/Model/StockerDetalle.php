<?php

namespace App\Http\Controllers\Aoicollector\Model;

use App\Http\Controllers\Trazabilidad\Declaracion\Wip\Wip;
use Illuminate\Database\Eloquent\Model;

class StockerDetalle extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'stocker_detalle';

    public $fillable = ['id_stocker','id_panel'];

    public $timestamps = false;

    public function joinPanel()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Panel', 'id', 'id_panel');
    }
}
