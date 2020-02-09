<?php

namespace App\Http\Controllers\Npmpicker\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class NpmpickerPingAbmCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_linea' => 'required|integer',
            'turno' => 'required|string',
            'maquina' => 'required|string',
            'ping' => 'required|date',
            'hostname' => 'required|string',
            'version' => 'required|string',
            'flag'=>'required|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'id_linea' => 'El campo id_linea',
            'turno' => 'El campo turno',
            'maquina' => 'El campo maquina',
            'ping' => 'El campo ping',
            'hostname' => 'El campo hostname',
            'version' => 'El campo version',
            'flag' => 'El campo flag'
        ];
    }

    public function messages()
    {
        return [
            'id_linea.required' => 'id_linea es Requerido',
            'turno.required' => 'turno es Requerido',
            'maquina.required' => 'maquina es Requerido',
            'ping.required' => 'ping es Requerido',
            'hostname.required' => 'hostname es Requerido',
            'version.required' => 'version es Requerido',
            'flag.required' => 'flag es Requerido'
        ];
    }
}
