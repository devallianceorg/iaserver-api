<?php

namespace App\Http\Controllers\Aoicollector\v1\Cuarentena;

use Carbon\Carbon;
use App\Http\Controllers\Aoicollector\v1\Inspection\FindInspection;
use App\Http\Controllers\Aoicollector\v1\Model\Cuarentena;
use App\Http\Controllers\Aoicollector\v1\Model\CuarentenaDetalle;
use App\Http\Controllers\Email\Email;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AgregarCuarentena extends Controller
{
    public function multiple($id_cuarentena="",$input="",$motivo="", $op="")
    {
        $create = false;
        $regex = '/(STK[0-9]+|[0-9]+)/';

        if($id_cuarentena =='')
        {
            $id_cuarentena = Input::get('id_cuarentena');
        }

        if($motivo =='')
        {
            $motivo = Input::get('motivo');
        }


        if ($input == '')
        {
            $input = Input::get('agregarmultiple');
        }
        preg_match_all($regex, $input, $matches);

        $cuarentena = Cuarentena::find($id_cuarentena);

        if($cuarentena == null && !empty($motivo))
        {
            if(!isset(Auth::user()->id))
            {
                $user_id = 71; //id del usuario AOI Collector
            }
            else
            {
                $user_id = Auth::user()->id;
            }
            $cuarentena = new Cuarentena();
            $cuarentena->id_user_calidad = $user_id;
            $cuarentena->motivo = $motivo;
            $cuarentena->op = $op;                              // se agrega OP by NGC, 01/10/2019 
            $cuarentena->created_at = new Carbon();
            $cuarentena->updated_at = new Carbon();
            $cuarentena->released_at= null;

            $cuarentena->save();

            $id_cuarentena = $cuarentena->id;

            $create = true;
        }

        if($cuarentena==null) {
            return back()->with('message','Por favor complete todos los campos para crear la cuarentena');
        }

        foreach ($matches[0] as $barcode)
        {
            if(starts_with($barcode,'STK')) {

                dd('Agregar stocker completo '.$barcode);
            } else {
                $cuarentena = CuarentenaDetalle::where('barcode',$barcode)->first();

                if(isset($cuarentena))
                {
                    // Cuarentena existe!, quito release y actualizo update_at
                    $cuarentena->updated_at = new Carbon();
                    $cuarentena->released_at = null;
                    $cuarentena->save();
                } else {
                    // Nueva cuarentena
                    $find = new FindInspection();
                    $find->onlyLast = true;
                    $result = $find->barcode($barcode,'');

                    if(isset($result->last))
                    {
                        $add = new CuarentenaDetalle();
                        $add->id_cuarentena = $id_cuarentena;
                        $add->barcode = $barcode;
                        $add->created_at = new Carbon();
                        $add->updated_at = new Carbon();
                        $add->released_at= null;
                        $add->save();
                    }
                }
            }
        }

        if($create) {
/*
            $message = array(
                "data"=>[
                    "Placas comprometidas" => count($matches[0])
                ]
            );

            $email = new Email();
            $email->send("Matias","matias.flores@newsan.com.ar",'Cuarentena creada',$message,'aoicollector.cuarentena.email.created');*/

            return redirect('aoicollector/cuarentena')->with('message','Cuarentena creada con exito!');
        } else {
            /*$message = array(
                "data"=>[
                    "Placas agregadas a cuarentena existente" => count($matches[0])
                ]
            );

            $email = new Email();
            $email->send("Matias","matias.flores@newsan.com.ar",'Se agregaron mas placas a cuarentena',$message,'aoicollector.cuarentena.email.updated');
*/
            return back()->with('message','Adjuntar cuarentena ejecutado con exito!');
        }
    }

    public function single($barcode, $id_cuarentena)
    {

    }
}