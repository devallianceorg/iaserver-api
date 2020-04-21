<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class PanelHistory extends Model
{
  protected $connection = 'aoidata';
  protected $table = 'history_inspeccion_panel';
  public $timestamps = false;

  /**
     * Relacion de history_inspeccion_panel.id_maquina con maquina.id
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maquina()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Maquina', 'id', 'id_maquina');
    }

    public function joinBloques()
    {
        return $this->hasMany('App\Http\Controllers\Aoicollector\Model\BloqueHistory', 'id_panel_history', 'id_panel_history');
    }

    public function joinPanel()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Panel', 'id', 'id');
    }

    public function joinFirstInspection()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\PanelHistory', 'id_panel_history', 'first_history_inspeccion_panel');
    }

    public function joinLastInspection()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\PanelHistory', 'id_panel_history', 'last_history_inspeccion_panel');
    }

    public function twip()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\TransaccionWip', 'id_panel', 'id');
    }

    public function joinStockerDetalle()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\StockerDetalle', 'id_panel', 'id');
    }

    public function joinProduccion()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Produccion', 'id_maquina', 'id_maquina');
    }
}
