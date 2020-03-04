<?php

namespace App\Http\Controllers\Npmpicker\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class NpmpickerPingAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ping' => 'required|string',
            'hostname' => 'required|string',
            'version' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'ping' => 'El campo ping',
            'hostname' => 'El campo hostname',
            'version' => 'El campo version'
        ];
    }

    public function messages()
    {
        return [
            'ping.required' => 'ping es Requerido',
            'hostname.required' => 'hostname es Requerido',
            'version.required' => 'version es Requerido'
        ];
    }
}
