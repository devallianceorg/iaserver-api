<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class PingAbmUpdateReq extends FormRequest
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
            'turno' => 'string',
            'maquina' => 'string',
            'hostname' => 'string',
            'version' => 'string',
            'flag'=>'integer'
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
