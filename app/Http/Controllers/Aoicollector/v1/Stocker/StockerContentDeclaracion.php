<?php
namespace App\Http\Controllers\Aoicollector\v1\Stocker\Src;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class StockerContentDeclaracion extends Controller
{
    public $declarado = false;
    public $parcial = false;
    public $pendiente = false;
    public $error = false;

    public $declarado_total = 0;
    public $parcial_total = 0;
    public $pendiente_total = 0;
    public $error_total = 0;

    public function process($unidades)
    {
        if($this->pendiente_total > 0) {
            $this->pendiente = true;
        }

        if($this->error_total > 0) {
            $this->error = true;
        }

        if(!$this->pendiente && !$this->error) {
            if ($this->declarado_total > 0) {
                if($unidades <= $this->declarado_total)
                {
                    $this->declarado = true;
                } else
                {
                    $this->parcial = true;
                    $this->parcial_total = $unidades - $this->declarado_total;
                }
            }
        }

        return $this;
    }
}
