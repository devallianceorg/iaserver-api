<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lavado extends Model
{
    protected $connection = 'stencil';
    protected $table = 'datos';
    public $timestamps = false;

    protected $fillable = [
        'id_operador','codigo','fecha','hora'
    ];

    public function setCodigoAttribute($value)
    {
        $this->attributes['codigo'] = strtoupper($value);
    }

    public $with = ['operador:id,name'];

    public function operador()
    {
        return $this->hasOne(User::class, 'id', 'id_operador');
    }

}
