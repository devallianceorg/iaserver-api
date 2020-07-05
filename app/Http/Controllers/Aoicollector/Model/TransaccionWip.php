<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaccionWip extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'transaccion_wip';

    public function joinRoute()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\StockerRoute', 'id', 'id_last_route');
    }
}
