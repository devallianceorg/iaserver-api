<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    protected $connection = 'stencil';
    protected $table = 'observaciones';
    public $timestamps = false;

    public $fillable = ['codigo','id_operador','texto','fecha','hora'];

    public $with = ['operador:id,name'];

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }

    public function operador()
    {
        return $this->hasOne(User::class, 'id', 'id_operador');
    }
}
