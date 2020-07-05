<?php

namespace App\Http\Controllers\Smtdatabase\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class OrdenTrabajoAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'modelo' => 'required|string',
            'lote' => 'required|string',
            'panel' => 'required|string',
            'semielaborado' => 'required|string',
            'qty' => 'required|integer'
        ];
    }

    public function attributes()
    {
        return [
            'modelo' => 'El campo modelo',
            'lote' => 'El campo lote',
            'panel' => 'El campo panel',
            'semielaborado' => 'El campo semielaborado',
            'qty' => 'El campo qty'
        ];
    }

    public function messages()
    {
        return [
            'modelo.required' => 'modelo es Requerido',
            'lote.required' => 'lote es Requerido',
            'panel.required' => 'panel es Requerido',
            'semielaborado.required' => 'semielaborado es Requerido',
            'qty.required' => 'qty es Requerido'
        ];
    }
}
