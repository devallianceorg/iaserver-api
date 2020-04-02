<?php

namespace App\Http\Controllers\Smtdatabase\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class SmtdatabaseIngenieriaAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha_modificacion' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'fecha_modificacion' => 'El campo fecha_modificacion'
        ];
    }

    public function messages()
    {
        return [
            'fecha_modificacion.required' => 'fecha_modificacion es Requerido'
        ];
    }
}
