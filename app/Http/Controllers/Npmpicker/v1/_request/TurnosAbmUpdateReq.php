<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class TurnosAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'nombre' => 'string',
            'turno' => 'string',
            'desde' => 'date_format:H:i:s',
            'hasta' => 'date_format:H:i:s',
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
