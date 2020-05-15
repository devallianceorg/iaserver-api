<?php

namespace App\Http\Controllers\ControlDeStencil\v1\Model;

use Illuminate\Database\Eloquent\Model;

class Tension extends Model
{
    protected $connection = 'stencil';
    protected $table = '_tension';
    public $timestamps = false;
}
