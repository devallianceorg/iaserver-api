<?php

namespace App\Http\Controllers\Npmpicker\v1\_model;

use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    protected $table = 'ping';
    protected $connection = 'npmpicker';
    public $timestamps = false;

    protected $fillable = [
        'id_linea','turno','maquina','hostname','version','flag','ping'
    ];

    protected $casts = [
        'ping' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
