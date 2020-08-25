<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use Illuminate\Database\Eloquent\Model;

class Stencil extends Model
{
    protected $table = 'stencil';
    protected $connection = 'stencil';
    public $timestamps = false;

    protected $fillable = [
        'codigo','modelo','placa','lado','serie','job','pcb','cliente','usos','ingreso'
    ];

    protected $with = ['ubicacion'];
    protected $withCount = ['observaciones'];

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }

    public function ubicacion()
    {
        return $this->hasOne(StencilUbicacion::class, 'codigo', 'codigo');
    }

    public function observaciones()
    {
        return $this->hasMany(Observaciones::class, 'codigo', 'codigo');
    }
}
