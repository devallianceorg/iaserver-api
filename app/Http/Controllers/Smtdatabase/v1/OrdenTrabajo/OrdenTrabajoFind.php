<?php

namespace App\Http\Controllers\Smtdatabase\v1\OrdenTrabajo;

use App\Http\Controllers\Smtdatabase\v1\Model\OrdenTrabajo;
use App\Http\Controllers\Controller;

class OrdenTrabajoFind extends Controller
{
    /**
     * Localiza todos los paneles de la OP que contengan MEM-%
     *
     * @param $query empty
     * @param string $op
     * @return Model
     */
    public static function findMemoryByOp($op)
    {
        // Hay que arreglar las migraciones de smtdatabase luego

        // return OrdenTrabajo::where('panel','like','MEM-%')
        //     ->where('OP',$op)
        //     ->first();
        return [];
    }
}
