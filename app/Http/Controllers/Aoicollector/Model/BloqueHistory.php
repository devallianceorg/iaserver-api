<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class BloqueHistory extends Model
{
  protected $connection = 'aoidata';
  protected $table = 'history_inspeccion_bloque';
  public $timestamps = false;

  public function panel()
  {
      return $this->hasOne('App\Http\Controllers\Aoicollector\Model\PanelHistory', 'id_panel_history', 'id_panel_history');
  }
}