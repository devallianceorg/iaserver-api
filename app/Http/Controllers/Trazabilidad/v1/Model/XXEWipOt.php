<?php
namespace App\Http\Controllers\Trazabilidad\v1\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class XXEWipOt extends Model
{
    protected $connection = 'sqlebs';
    protected $table = 'XXE_WIP_OT';

    public $timestamps = false;
}
