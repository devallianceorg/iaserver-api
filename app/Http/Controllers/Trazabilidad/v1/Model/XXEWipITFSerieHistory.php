<?php
namespace App\Http\Controllers\Trazabilidad\v1\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class XXEWipITFSerieHistory extends Model
{
    protected $connection = 'sqlebs';
    protected $table = 'XXE_WIP_ITF_SERIE_History';

    public $timestamps = false;

    public function transok()
    {
        return $this->hasOne('App\Http\Controllers\Trazabilidad\v1\Model\TransOkDet', 'id', 'trans_ok');
    }

    public function scopeNoLock($query)
    {
        return $query->from(DB::raw(self::getTable() . ' with (nolock)'));
    }
}
