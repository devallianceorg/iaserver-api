<?php

namespace App\Http\Controllers\Smtdatabase\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class SmtdatabaseIngenieriaAbmCreateReq extends FormRequest
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
            'hash' => 'required|string',
            'fecha_modificacion' => 'required|string',
            'version' => 'required|string'

        ];
    }

    public function attributes()
    {
        return [
            'modelo' => 'El campo modelo',
            'lote' => 'El campo lote',
            'hash' => 'El campo hash',
            'fecha_modificacion' => 'El campo fecha_modificacion',
            'version' => 'El campo version'
        ];
    }

    public function messages()
    {
        return [
            'modelo.required' => 'modelo es Requerido',
            'lote.required' => 'lote es Requerido',
            'hash.required' => 'hash es Requerido',
            'fecha_modificacion.required' => 'fecha_modificacion es Requerido',
            'op.required' => 'op es Requerido',
        ];
    }
}
