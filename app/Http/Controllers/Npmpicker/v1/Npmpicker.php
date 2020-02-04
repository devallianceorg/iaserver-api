<?php

namespace App\Http\Controllers\Npmpicker\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\ApiConsume;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerData;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerPing;
use App\Http\Controllers\Npmpicker\v1\Model\NpmpickerStat;
use Carbon\Carbon;

class Npmpicker extends Controller
{
    public function index()
    {
        $name = 'Npmpicker';
        $version = 'v1';

        $output = compact('name','version');
    	return $output;
    }

    public function GetPing($fecha=null) {
        if($fecha==null) {
            $fecha = Carbon::now()->toDateString();
        }

        $stat = NpmpickerPing::whereDate('ping',$fecha)
            ->get();

        $linea = $stat->groupBy('id_linea');
        return compact('linea');
    }

    public function GetFeeders($fecha=null,$id_linea,$turno='M',$estado=null) {
        if($fecha==null) {
            $fecha = Carbon::now()->toDateString();
        }

        $feeders = NpmpickerStat::whereDate('fecha',$fecha)
            ->where('id_linea',$id_linea)
            ->where('turno',$turno);

        if($estado) {
            $feeders->where('estado',$estado);
        }
        $feeders = $feeders->with('detail')->get();

        return compact('feeders');
    }

    public function GetFeederDetail($id_stat) {
        $detail = NpmpickerData::where('id_stat',$id_stat)
            ->get();

        return compact('detail');
    }

    /*
    public function GetLinea($fecha,$id_linea,$turno)
    {
        $params = [
            'id_linea' => $id_linea,
            'turno' => $turno,
            'fecha' => '"'.$fecha.'"',
            'mode'=> 'GetAll'
        ];
        
        // Consume API
        $uri = 'iaserver-v2';
        $api = new ApiConsume($uri);
        $api->get('aplicacion/npmpicker/jsonservice/npmpicker.php',$params);
        if($api->hasError()) { return $api->getError(); }

        return $api->response();
    }

    public function GetStat($id_stat=null)
    {
        $params = [
            'id_stat' => $id_stat,
            'mode'=> 'GetFeedersInestables'
        ];

        // Consume API
        $uri = 'iaserver-v2';
        $api = new ApiConsume($uri);
        $api->get('aplicacion/npmpicker/jsonservice/npmpicker.php',$params);
        if($api->hasError()) { return $api->getError(); }

        return $api->response();
    }*/
}
