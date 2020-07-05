<?php

namespace App\Http\Controllers\Aoicollector\Model;

use Carbon\Carbon;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Stocker extends Model
{
    protected $connection = 'aoidata';
    protected $table = 'stocker';

    protected $fillable = ['semielaborado','limite','bloques'];

    public function joinPanel()
    {
        return $this->hasOne('App\Http\Controllers\Aoicollector\Model\Stocker', 'id', 'id_panel');
    }

    public function joinStockerTraza()
    {
        return $this->hasMany('App\Http\Controllers\Aoicollector\Model\StockerTraza', 'id_stocker', 'id');
    }

    
}