<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    protected $table = 'lotes';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

   

    protected $fillable = [
        'id','id_ingenieria','id_ver','bom','descripcion','lote_version','item_num','logop','posicion','componente','descripcion_componente','cantidad','unidad_medida','asignacion','fecha','subinventario','localizador','tipo_material','kit','placa','sustituto','item_cygnus','item_type'
    ];
}
