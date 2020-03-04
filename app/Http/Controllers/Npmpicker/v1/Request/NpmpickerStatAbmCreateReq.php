<?php

namespace App\Http\Controllers\Npmpicker\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class NpmpickerStatAbmCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_linea' => 'required|integer',
            'maquina' => 'required|string',
            'modulo' => 'required|string',
            'tabla' => 'required|string',
            'feeder' => 'required|string',
            'partnumber'=>'required|string',
            'programa' => 'required|string',
            'op' => 'required|string',
            'total_error' => 'required|integer',
            'total_pickup' => 'required|integer',
            'fecha' => 'required|string',
            'hora' => 'required|string',
            'turno' => 'required|string',
            'count' => 'required|integer',
            'estado' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'id_linea' => 'El campo id_linea',
            'maquina' => 'El campo maquina',
            'modulo' => 'El campo modulo',
            'tabla' => 'El campo tabla',
            'feeder' => 'El campo feeder',
            'partnumber' => 'El campo partnumber',
            'programa' => 'El campo programa',
            'op' => 'El campo op',
            'total_error' => 'El campo total_error',
            'total_pickup' => 'El campo total_pickup',
            'fecha' => 'El campo fecha',
            'hora' => 'El campo hora',
            'turno' => 'El campo turno',
            'count' => 'El campo count',
            'estado' => 'El campo estado',
        ];
    }

    public function messages()
    {
        return [
            'id_linea.required' => 'id_linea es Requerido',
            'maquina.required' => 'maquina es Requerido',
            'modulo.required' => 'modulo es Requerido',
            'tabla.required' => 'tabla es Requerido',
            'feeder.required' => 'feeder es Requerido',
            'partnumber.required' => 'partnumber es Requerido',
            'programa.required' => 'programa es Requerido',
            'op.required' => 'op es Requerido',
            'total_error.required' => 'total_error es Requerido',
            'total_pickup.required' => 'total_pickup es Requerido',
            'fecha.required' => 'fecha es Requerido',
            'hora.required' => 'hora es Requerido',
            'turno.required' => 'turno es Requerido',
            'count.required' => 'count es Requerido',
            'estado.required' => 'estado es Requerido'
        ];
    }
}
