<?php

namespace App\Http\Controllers\Npmpicker\v1\_model;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';
    protected $connection = 'npmpicker';
    public $timestamps = false;
    
    protected $fillable = [
        'id','id_stat','total_error','total_pickup','hora','inspeccion','ajuste'
    ];
}
