<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    protected $table = 'materiales';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

   

    protected $fillable = [
        'id','logop','componente','descripcion_componente','asignacion','item_cygnus','pcb'
    ];
}
