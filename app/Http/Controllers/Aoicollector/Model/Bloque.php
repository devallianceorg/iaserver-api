<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
  protected $connection = 'aoidata';
  protected $table = 'inspeccion_bloque';
  public $timestamps = false;

  public function panel()
  {
      return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Panel', 'id', 'id_panel');
  }
}