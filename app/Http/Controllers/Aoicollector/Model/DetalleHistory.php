<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleHistory extends Model
{
  protected $connection = 'aoidata';
  protected $table = 'history_inspeccion_detalle';

  public function scopeLeftJoinFaultcode($query,$tipo)
  {
      return $query->leftJoin('aoidata.'.$tipo.'_faultcode','aoidata.'.$tipo.'_faultcode.faultcode','=','aoidata.history_inspeccion_detalle.faultcode');
  }

  public function joinFaultcode()
  {
      return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Faultcode', 'faultcode', 'faultcode');
  }

  public function scopeDescripcion() {
      $f = $this->joinFaultcode;
      return ($f == null) ? 'Descripcion desconocida' : $f->descripcion;
  }
}