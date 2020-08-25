<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Armario;

use App\Http\Controllers\ControlDeStencil\v1\_model\Armario;
use App\Http\Controllers\Controller;

class ArmarioFind extends Controller
{
    public function find() {
        $find = Armario::paginate();
        return $find;
    }
}
