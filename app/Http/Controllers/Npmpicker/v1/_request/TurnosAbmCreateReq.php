<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class TurnosAbmCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'turno' => 'required|string',
            'desde' => 'required|date_format:H:i:s',
            'hasta' => 'required|date_format:H:i:s',
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
