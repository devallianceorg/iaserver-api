<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class StatAbmCreateReq extends FormRequest
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
            'turno' => 'required|string',
            'count' => 'required|integer',
            'estado' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
