<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Armario extends Model
{
    protected $connection = 'stencil';
    protected $table = '_armario';
    public $timestamps = false;
}
