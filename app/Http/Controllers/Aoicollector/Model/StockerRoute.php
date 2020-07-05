<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class StockerRoute extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'stocker_route';
}
