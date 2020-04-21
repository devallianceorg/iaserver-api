<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class Faultcode extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'rns_faultcode';

}