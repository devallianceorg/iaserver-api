<?php

namespace App\Http\Controllers\Npmpicker\v1\Model;

use Illuminate\Database\Eloquent\Model;

class NpmpickerPing extends Model
{
    protected $table = 'ping';
    protected $connection = 'npmpicker';

    protected $casts = [
        'ping' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
