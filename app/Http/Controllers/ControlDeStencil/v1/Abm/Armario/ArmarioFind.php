<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Abm\Armario;

use App\Http\Controllers\ControlDeStencil\v1\Model\Armario;
use App\Http\Controllers\Controller;

class ArmarioFind extends Controller
{
    public function find() {
        $find = Armario::paginate();
        return $find;
    }
}
