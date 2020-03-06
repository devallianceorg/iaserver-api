<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Ingenieria extends Model
{
    protected $table = 'ingenieria';
    protected $connection = 'smtdatabase';
    public $timestamps = false;

   

    protected $fillable = [
        'id','modelo','lote','hash','fecha_modificacion','version'
    ];
}
