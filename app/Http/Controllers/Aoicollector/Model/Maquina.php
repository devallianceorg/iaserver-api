<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'maquina';
    
    public function scopeRns($query) {
        return $query->where('tipo','R')->get();
    }

    public function scopeVtwin($query) {
        return $query->where('tipo','W')->get();
    }

    public function scopeVts($query) {
        return $query->where('tipo','V')->get();
    }

    public function scopeKy($query) {
      return $query->where('tipo','Z')->get();
    }
}
