<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lavado extends Model
{
    protected $connection = 'stencil';
    protected $table = 'datos';
    public $timestamps = false;

    public $with = ['operador:id,name'];

    public function operador()
    {
        return $this->hasOne(User::class, 'id', 'id_operador');
    }

}
