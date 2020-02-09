<?php

namespace App\Http\Controllers\Npmpicker\v1\Model;

use Illuminate\Database\Eloquent\Model;

class NpmpickerStat extends Model
{
    protected $table = 'stat';
    protected $connection = 'npmpicker';

    protected $appends = ['fullname','rate','rate_level'];

    public function getFullnameAttribute()
    {
        return "{$this->maquina}-{$this->modulo} T{$this->tabla} {$this->feeder}";
    }

    public function getRateAttribute()
    {
        $percent = ($this->total_error * 100) / $this->total_pickup;
        $rate = round($percent, 2);

        return $rate;
    }

    public function getRateLevelAttribute()
    {
        if($this->rate>5) { return 'alto';}
        if($this->rate>2) { return 'medio';}

        return 'bajo';

    }

    public function detail()
    {
        return $this->hasMany(NpmpickerData::class, 'id_stat', 'id');
    }
}
