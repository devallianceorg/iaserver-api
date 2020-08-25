<?php

namespace App\Http\Controllers\Npmpicker\v1\_model;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $table = 'stat';
    protected $connection = 'npmpicker';
    public $timestamps = false;

    protected $appends = ['fullname','rate','rate_level'];
    protected $fillable = [
        "id_linea",
        "maquina",
        "modulo",
        "tabla",
        "feeder",
        "partnumber",
        "programa",
        "op",
        "total_error",
        "total_pickup",
        "fecha",
        "hora",
        "turno",
        "count",
        "estado"
    ];

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
        return $this->hasMany(Data::class, 'id_stat', 'id');
    }
}
