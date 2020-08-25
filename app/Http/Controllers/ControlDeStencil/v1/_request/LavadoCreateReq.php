<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class LavadoCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string',
            'id_operador' => 'required|integer',
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
