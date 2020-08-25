<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class LavadoUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'codigo' => 'string',
            'id_operador' => 'integer',
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
