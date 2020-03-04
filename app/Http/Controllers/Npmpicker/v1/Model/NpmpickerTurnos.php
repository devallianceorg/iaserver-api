<?php

namespace App\Http\Controllers\Npmpicker\v1\Model;

use Illuminate\Database\Eloquent\Model;

class NpmpickerTurnos extends Model
{
    protected $table = 'turnos';
    protected $connection = 'npmpicker';
    public $timestamps = false;

    protected $casts = [
        'desde' => 'datetime',
        'hasta' => 'datetime'
    ];

    protected $fillable = [
        'nombre','turno','desde','hasta'
    ];
}
