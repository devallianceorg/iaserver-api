<?php

namespace App\Http\Controllers\Smtdatabase\v1\Model;

use Illuminate\Database\Eloquent\Model;

class NewProductionTarget extends Model
{
    protected $table = 'new_production_target';
    protected $connection = 'smtdatabase';

    protected $fillable = [
        'id','linea','target'
    ];
}
