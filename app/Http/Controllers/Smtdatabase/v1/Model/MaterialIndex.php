<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class MaterialIndex extends Model
{
    protected $table = 'material_index';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

   

    protected $fillable = [
        'id','id_ingenieria','id_material'
    ];
}
