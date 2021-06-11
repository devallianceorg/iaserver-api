<?php

namespace IAServer\Http\Controllers\Aoicollector\Api\Components;

use IAServer\Http\Controllers\SMTDatabase\Model\Ingenieria;
use IAServer\Http\Controllers\SMTDatabase\Model\Lotes;
use Illuminate\Http\Request;

use IAServer\Http\Requests;
use IAServer\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ComponentsApi extends Controller
{
    public function ingenieria($model)
    {
        $output = Ingenieria::where('modelo',$model)->get();

        return Response::multiple($output);
    }

    public function lote($ingId)
    {
        $output = Lotes::where('id_ingenieria',$ingId)->get();

        return Response::multiple($output);
    }
}
