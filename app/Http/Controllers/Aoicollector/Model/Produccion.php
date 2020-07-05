<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'produccion';
    public $timestamps = false;
}
