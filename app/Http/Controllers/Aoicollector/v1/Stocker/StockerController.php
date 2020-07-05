<?php

namespace App\Http\Controllers\Aoicollector\v1\Stocker;

use App\Http\Controllers\Aoicollector\Model\Bloque;
use App\Http\Controllers\Aoicollector\Model\Panel;
use App\Http\Controllers\Aoicollector\Model\Produccion;
use App\Http\Controllers\Aoicollector\Model\Stocker;
use App\Http\Controllers\Aoicollector\Model\StockerTraza;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockerController extends Controller
{
    public static function vista()
    {
        $sql = Stocker::from("vi_stocker");
        return $sql;
    }

    public static function findByIdStocker($idStocker)
    {
        $sql = Stocker::from("vi_stocker")->where('id', $idStocker)->first();
        return $sql;
    }

    public static function findByStockerBarcode($stockerBarcode)
    {
        $sql = Stocker::from("vi_stocker")->where('barcode', $stockerBarcode)->first();
        return $sql;
    }

    /**
     * 	Desvincula un stocker relacionado a una AOI de produccion.
     *
     * @param $aoi_barcode
     */
    public static function changeProductionStocker($aoiBarcode,$id_stocker=null)
    {
        if(!empty($aoiBarcode))
        {
            $prod = Produccion::where('barcode',$aoiBarcode)->first();
            $prod->id_stocker = null;
            $prod->save();
        } else
        {
            // changeProductionStocker(null,4245)
            if(is_numeric($id_stocker))
            {
                $prod = Produccion::where('id_stocker',$id_stocker)->first();
                if (isset($prod)) {
                    $prod->id_stocker = null;
                    $prod->save();
                }
            }
        }
    }

    // DEPRECAR
    public static function sp_stockerSet(Produccion $produccion, $stocker, $semielaborado)
    {
        $query = "CALL aoidata.sp_stockerSet('".$produccion->barcode."','".$stocker->barcode."','".$produccion->op."','".$stocker->limite."','".$stocker->bloques."','".$semielaborado."');";
        $sql = DB::connection('aoidata')->select($query);

        return $sql;
    }

    // DEPRECAR
    public static function sp_stockerReset($stocker)
    {
        $query = "CALL aoidata.sp_stockerReset('".$stocker->barcode."');";
        $sql = DB::connection('aoidata')->select($query);
        return $sql;
    }

    // DEPRECAR
    public static function sp_stockerAddPanel($idPanel,$idStocker, $manualMode=0)
    {
        $query = "CALL aoidata.sp_stockerAddPanel_opt('".$idPanel."','".$idStocker."', ".$manualMode.");";
        $sql = DB::connection('aoidata')->select($query);
        return $sql;
    }

    public function liberar()
    {
        return self::sp_stockerReset($this);
    }

    public function sendToRouteId($id_route)
    {
        $traza = new StockerTraza();
        $traza->id_stocker = $this->id;
        $traza->id_stocker_route = $id_route;
        $traza->created_at = Carbon::now();

        $user = Auth::user();
        if($user)
        {
            $traza->id_user = $user->id;
        }
        $traza->save();
        return $traza;
    }

    public function lavados()
    {
        return StockerTraza::where('id_stocker_route',7)
            ->where('id_stocker',$this->id);
    }

    public function inspector()
    {
        $inspector = null;

        $inspector = User::find($this->id_user);
        if ($inspector != null) {
            if ($inspector->hasProfile()) {
                $inspector->fullname = $inspector->profile->fullname();
            } else {
                $inspector->fullname = $inspector->name;
            }
        }
        return $inspector;
    }
}