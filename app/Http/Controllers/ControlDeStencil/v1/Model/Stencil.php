<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Stencil extends Model
{
    protected $table = 'stencil';
    protected $connection = 'stencil';
    public $timestamps = false;

    protected $with = ['ubicacion'];
    protected $withCount = ['observaciones'];
    
    public function ubicacion()
    {
        return $this->hasOne(StencilUbicacion::class, 'codigo', 'codigo');
    }

    public function observaciones()
    {
        return $this->hasMany(Observaciones::class, 'codigo', 'codigo');
    }
}
