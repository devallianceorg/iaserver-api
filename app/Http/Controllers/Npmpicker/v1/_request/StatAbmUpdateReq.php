<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class StatAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'id_linea' => 'integer',
            'maquina' => 'string',
            'modulo' => 'string',
            'tabla' => 'string',
            'feeder' => 'string',
            'partnumber'=>'string',
            'programa' => 'string',
            'op' => 'string',
            'total_error' => 'integer',
            'total_pickup' => 'integer',
            'turno' => 'string',
            'count' => 'integer',
            'estado' => 'string'
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
