<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Panel extends Model
{
  protected $connection = 'aoidata';
  protected $table = 'inspeccion_panel';


  public function scopeBuscarPanel($query, $barcode)
  {
      return $this->where('panel_barcode',$barcode)
          ->leftJoin('maquina', 'maquina.id','=','id_maquina')
          ->select(['inspeccion_panel.*','maquina.linea'])
          ->get();
  }

  /**
   * Hace un join de la ultima inspeccion del panel
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function joinBloques()
  {
      return $this->hasMany('App\Http\Controllers\Aoicollector\Model\BloqueHistory', 'id_panel_history', 'last_history_inspeccion_panel');
  }

  public function twip()
  {
      return $this->hasOne('App\Http\Controllers\Aoicollector\Model\TransaccionWip', 'id_panel', 'id');
  }

}