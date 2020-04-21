<?php

namespace App\Http\Controllers\Aoicollector\v1;

use App\Http\Controllers\Controller;

class MaquinaController extends Controller
{
  public function machineInfo($id_maquina){
    return $this->where('id',$id_maquina)->first();
  }
}