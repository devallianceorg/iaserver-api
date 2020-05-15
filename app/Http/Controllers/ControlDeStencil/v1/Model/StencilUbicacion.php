<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Model;

use Illuminate\Database\Eloquent\Model;

class StencilUbicacion extends Model
{
    protected $connection = 'stencil';
    protected $table = 'stencil_ubicacion';
    public $timestamps = false;

    protected $appends = ['codigo_ubicacion'];

    public function getCodigoUbicacionAttribute()
    {
        return "{$this->id_armario}.{$this->fila}.{$this->columna}";
    }

}
