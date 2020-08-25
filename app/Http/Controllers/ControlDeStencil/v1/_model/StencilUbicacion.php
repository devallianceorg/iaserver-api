<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use Illuminate\Database\Eloquent\Model;

class StencilUbicacion extends Model
{
    protected $connection = 'stencil';
    protected $table = 'stencil_ubicacion';
    public $timestamps = false;

    protected $fillable = ['codigo','id_armario','fila','columna'];

    protected $appends = ['codigo_ubicacion'];

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }

    public function getCodigoUbicacionAttribute()
    {
        return "{$this->id_armario}.{$this->fila}.{$this->columna}";
    }

}
