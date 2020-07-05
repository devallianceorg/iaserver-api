<?php
namespace App\Http\Controllers\Trazabilidad\v1\Model;

use Illuminate\Database\Eloquent\Model;

class TransOkDet extends Model
{
    protected $connection = 'sqlebs';
    protected $table = 'Trans_Ok_det';

    public $timestamps = false;
}
