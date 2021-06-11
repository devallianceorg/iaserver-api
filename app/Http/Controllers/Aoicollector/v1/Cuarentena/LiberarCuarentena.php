<?php

namespace App\Http\Controllers\Aoicollector\v1\Cuarentena;

use Carbon\Carbon;
use App\Http\Controllers\Aoicollector\Model\CuarentenaDetalle;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LiberarCuarentena extends Controller
{
    public function multiple()
    {
        $regex = '/(STK[0-9]+|[0-9]+)/';

        $input = Input::get('liberarmultiple');
        preg_match_all($regex, $input, $matches);

        $barcodes = [];
        foreach ($matches[0] as $barcode)
        {
            if(starts_with($barcode,'STK')) {
                echo 'Liberar stocker completo '.$barcode.'<br>';
            } else {
                $cuarentena = CuarentenaDetalle::where('barcode',$barcode)->first();
                if(isset($cuarentena))
                {
                    $cuarentena->released_at = new Carbon();
                    $cuarentena->save();
                }
            }
        }

        return back()->with('message','Liberacion de cuarentena ejecutado con exito!');
    }

    public function single($barcode)
    {

    }
}