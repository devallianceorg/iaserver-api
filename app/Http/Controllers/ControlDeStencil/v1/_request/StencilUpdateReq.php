<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class StencilUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|string',
            'codigo' => 'string',
            'modelo' => 'string',
            'placa' => 'string',
            'lado' => 'string',
            'serie' => 'string',
            'job' => 'string',
            'pcb' => 'string',
            'cliente' => 'string',
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
