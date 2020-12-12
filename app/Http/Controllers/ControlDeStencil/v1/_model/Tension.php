<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tension extends Model
{
    protected $connection = 'stencil';
    protected $table = '_tension';
    public $timestamps = false;
    protected $fillable = ['id_operador','codigo','tension','fecha'];

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
