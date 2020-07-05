<?php

namespace App\Http\Controllers\Smtdatabase\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class OrdenTrabajoAbmCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'op' => 'required|string',
            'modelo' => 'required|string',
            'lote' => 'required|string',
            'panel' => 'required|string',
            'semielaborado' => 'required|string',
            'qty' => 'required|integer',
            'prod_aoi' => 'required|integer',
            'prod_man' => 'required|integer'
        ];
    }

    public function attributes()
    {
        return [
            'op' => 'El campo op',
            'modelo' => 'El campo modelo',
            'lote' => 'El campo lote',
            'panel' => 'El campo panel',
            'semielaborado' => 'El campo semielaborado',
            'qty' => 'El campo qty',
            'prod_aoi' => 'El campo prod_aoi',
            'prod_man' => 'El campo prod_man'
        ];
    }

    public function messages()
    {
        return [
            'op.required' => 'op es Requerido',
            'modelo.required' => 'modelo es Requerido',
            'lote.required' => 'lote es Requerido',
            'panel.required' => 'panel es Requerido',
            'semielaborado.required' => 'semielaborado es Requerido',
            'qty.required' => 'qty es Requerido',
            'prod_aoi.required' => 'prod_aoi es Requerido',
            'prod_man.required' => 'prod_man es Requerido'
        ];
    }
}
