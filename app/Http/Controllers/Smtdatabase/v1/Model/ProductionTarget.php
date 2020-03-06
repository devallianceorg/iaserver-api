<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionTarget extends Model
{
    protected $table = 'production_target';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

   

    protected $fillable = [
        'id','id_orden_trabajo','target'
    ];
}
