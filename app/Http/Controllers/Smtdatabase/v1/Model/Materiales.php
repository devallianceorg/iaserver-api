<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    protected $connection = 'smtdatabase';
    protected $table = 'materiales';
    public $timestamps = false;

   

    protected $fillable = [
        'id','logop','componente','descripcion_componente','asignacion','item_cygnus','pcb'
    ];

    public function joinMaterialIndex()
    {
        return $this->hasMany('App\Http\Controllers\Smtdatabase\v1\Model\MaterialIndex','id_material','id');
    }
}
