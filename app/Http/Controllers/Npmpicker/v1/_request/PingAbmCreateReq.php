<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class PingAbmCreateReq extends FormRequest
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
            'hostname' => 'required|string',
            'version' => 'required|string',
            'flag'=>'required|integer'
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
