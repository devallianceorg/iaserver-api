<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'orden_trabajo';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

    protected $fillable = [
        'id','op','modelo','lote','panel','prod_aoi','prod_man','qty','semielaborado','created_at'
    ];
}
