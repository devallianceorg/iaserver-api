<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class StencilCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string',
            'modelo' => 'required|string',
            'placa' => 'required|string',
            'lado' => 'required|string',
            'serie' => 'required|string',
            'job' => 'required|string',
            'pcb' => 'required|string',
            'cliente' => 'required|string',
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
