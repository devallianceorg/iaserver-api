<?php

namespace App\Http\Controllers\Npmpicker\v1\Turnos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TurnosCtrl extends Controller
{
    public $inicioTurnoTarde = '15:00';

    public function getTurnoActual()
    {
        // Turno por defecto M (Mañana)
        $turno = 'M';
        $hora = Carbon::now()->format('H:i');
        $tarde = new Carbon($this->inicioTurnoTarde);
        $tarde = $tarde->format('H:i');

        if($hora < $tarde)
        {
            $turno = 'M';
        }
        else
        {
            $turno = 'T';
        }

        return compact('turno');
    }
}
