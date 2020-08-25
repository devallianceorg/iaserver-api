<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use Illuminate\Database\Eloquent\Model;

class Armario extends Model
{
    protected $connection = 'stencil';
    protected $table = '_armario';
    public $timestamps = false;

    protected $fillable = [
        'nombre','fila','columna'
    ];
}
