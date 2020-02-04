<?php

namespace App\Http\Controllers\Npmpicker\v1\Model;

use Illuminate\Database\Eloquent\Model;

class NpmpickerData extends Model
{
    protected $table = 'data';
    protected $connection = 'npmpicker';

    protected $appends = ['rate'];

    public function getRateAttribute()
    {
        $percent = ($this->total_error * 100) / $this->total_pickup;
        $rate = round($percent, 2);

        return $rate;
    }
}
